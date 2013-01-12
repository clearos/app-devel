
Name: app-devel
Epoch: 1
Version: 1.4.14
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
Requires: app-base-core >= 1:1.2.8
Requires: app-language-core
Requires: bc
Requires: clearos-framework >= 6.4.15
Requires: rsync

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
install -D -m 0755 packaging/get_translations %{buildroot}/usr/sbin/get_translations

%post
logger -p local6.notice -t installer 'app-devel - installing'

%post core
logger -p local6.notice -t installer 'app-devel-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/devel/deploy/install ] && /usr/clearos/apps/devel/deploy/install
fi

[ -x /usr/clearos/apps/devel/deploy/upgrade ] && /usr/clearos/apps/devel/deploy/upgrade

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

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/devel/controllers
/usr/clearos/apps/devel/htdocs
/usr/clearos/apps/devel/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/devel/packaging
%exclude /usr/clearos/apps/devel/tests
%dir /usr/clearos/apps/devel
%dir /etc/clearos/devel.d
/usr/clearos/apps/devel/deploy
/usr/clearos/apps/devel/language
/usr/clearos/apps/devel/libraries
/usr/sbin/get_translations
