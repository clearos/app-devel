<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'devel';
$app['version'] = '1.2.8';
$app['release'] = '1';
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
$app['subcategory'] = 'Developer'; // FIXME

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
    'app-base-core >= 1:1.2.8',
    'app-language-core',
    'bc',
    'clearos-framework >= 6.3.2',
    'rsync',
);

$app['core_file_manifest'] = array(
    'get_translations'=> array('target' => '/usr/sbin/get_translations',
        'mode' => '0755',
    ),
);

