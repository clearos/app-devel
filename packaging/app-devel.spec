
Name: app-devel
Epoch: 1
Version: 2.3.2
Release: 1%{dist}
Summary: Developer Tools
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
This page provides a quick developer overview of the theme and other widgets.

%package core
Summary: Developer Tools - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-base-core >= 1:2.3.4
Requires: app-language-core
Requires: app-tasks-core
Requires: bc
Requires: clearos-framework >= 6.5.4
Requires: php-common
Requires: rsync
Requires: wget
Requires: csplugin-events

%description core
This page provides a quick developer overview of the theme and other widgets.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/devel
cp -r * %{buildroot}/usr/clearos/apps/devel/

install -d -m 0755 %{buildroot}/etc/clearos/devel.d
install -D -m 0755 packaging/clearos %{buildroot}/usr/bin/clearos
install -D -m 0755 packaging/get_translations %{buildroot}/usr/sbin/get_translations

%post
logger -p local6.notice -t installer 'app-devel - installing'

%post core
logger -p local6.notice -t installer 'app-devel-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/devel/deploy/install ] && /usr/clearos/apps/devel/deploy/install
fi

[ -x /usr/clearos/apps/devel/deploy/upgrade ] && /usr/clearos/apps/devel/deploy/upgrade

if [ -x /usr/bin/eventsctl -a -S /var/lib/csplugin-events/eventsctl.socket ]; then
    /usr/bin/eventsctl -R --type DEVEL_MODE_APP --basename devel
    /usr/bin/eventsctl -R --type DEVEL_MODE_FRAME --basename devel
    /usr/bin/eventsctl -R --type DEVEL_MODE_THEME --basename devel
else
    logger -p local6.notice -t installer 'app-devel - events system not running, unable to register custom types.'
fi

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-devel - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-devel-core - uninstalling'
    [ -x /usr/clearos/apps/devel/deploy/uninstall ] && /usr/clearos/apps/devel/deploy/uninstall
fi

if [ -x /usr/bin/eventsctl -a -S /var/lib/csplugin-events/eventsctl.socket ]; then
    /usr/bin/eventsctl -D --type DEVEL_MODE_APP
    /usr/bin/eventsctl -D --type DEVEL_MODE_FRAME
    /usr/bin/eventsctl -D --type DEVEL_MODE_THEME
else
    logger -p local6.notice -t installer 'app-devel - events system not running, unable to unregister custom types.'
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/devel/controllers
/usr/clearos/apps/devel/htdocs
/usr/clearos/apps/devel/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/devel/packaging
%exclude /usr/clearos/apps/devel/unify.json
%dir /usr/clearos/apps/devel
%dir /etc/clearos/devel.d
/usr/clearos/apps/devel/deploy
/usr/clearos/apps/devel/language
/usr/clearos/apps/devel/libraries
/usr/bin/clearos
/usr/sbin/get_translations
