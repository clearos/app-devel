<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'devel';
$app['version'] = '2.4.12';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('devel_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('devel_app_name');
$app['category'] = lang('base_category_system');
$app['subcategory'] = lang('base_subcategory_developer');

////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['devel']['title'] = $app['name'];
$app['controllers']['theme']['title'] = lang('devel_theme_viewer');
$app['controllers']['wizard']['title'] = lang('base_wizard');
$app['controllers']['translations']['title'] = lang('devel_translations');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['core_requires'] = array(
    'app-base-core >= 1:2.3.4',
    'app-language-core',
    'app-tasks-core',
    'bc',
    'clearos-framework >= 7.3.9',
    'php-common',
    'rsync',
    'wget',
);

$app['core_file_manifest'] = array(
    'get_translations'=> array(
        'target' => '/usr/sbin/get_translations',
        'mode' => '0755',
    ),
    'clearos' => array(
        'target' => '/usr/bin/clearos',
        'mode' => '0755',
    ),
);

$app['core_directory_manifest'] = array(
    '/etc/clearos/devel.d' => array(),
);

/////////////////////////////////////////////////////////////////////////////
// App Events
/////////////////////////////////////////////////////////////////////////////

$app['event_types'] = array(
    'DEVEL_MODE_APP',
    'DEVEL_MODE_FRAME',
    'DEVEL_MODE_THEME',
);

/////////////////////////////////////////////////////////////////////////////
// App Removal Dependencies
/////////////////////////////////////////////////////////////////////////////

$app['delete_dependency'] = array(
    'app-devel-core'
);
