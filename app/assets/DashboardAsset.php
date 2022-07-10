<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
      "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css",
      'https://cdn.datatables.net/r/dt/jq-2.1.4,dt-1.10.9,b-1.0.3,b-flash-1.0.3/datatables.min.css',
      'https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css',
      'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css',
    //   "vendorAsests/select2/css/select2.min.css",
        "custom/css/smart_wizard_vertical.css",
        "vendorAsests/font-awesome/css/font-awesome.min.css",
        "https://use.fontawesome.com/releases/v5.3.1/css/all.css",
        "vendorAsests/themify-icons/css/themify-icons.css",
        "vendorAsests/flag-icon-css/css/flag-icon.min.css",
        "vendorAsests/bootstrap/dist/css/bootstrap.min.css",
        "vendorAsests/selectFX/css/cs-skin-elastic.css",
        "vendorAsests/jqvmap/dist/jqvmap.min.css",
        "css/style.css",
        "https://unpkg.com/@araujoigor/json-grid/dist/json-grid.css",
        "https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800"

    ];
    public $js = [
    //    "vendorAsests/jquery/dist/jquery.min.js",
    
       "vendorAsests/popper.js/dist/umd/popper.min.js",
       "vendorAsests/bootstrap/dist/js/bootstrap.min.js",
       "vendorAsests/chart.js/dist/Chart.bundle.min.js",
       // "js/dashboard.js",
       "custom/js/jquery.smartWizard.js",
       
       "vendorAsests/jqvmap/dist/jquery.vmap.min.js",
       "vendorAsests/jqvmap/examples/js/jquery.vmap.sampledata.js",
       "vendorAsests/jqvmap/dist/maps/jquery.vmap.world.js",
       "js/main.js",

    ];
    public $depends = [
        // 'fedemotta\datatables\DataTablesAsset',
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
    public $iconMap = [
     
        'glyphicons' => [
            'drag-handle' => 'fa fa-bars',
            'remove' => 'fa fa-times',
            'add' => 'fa fa-plus',
            'clone' => 'fa fa-files-o',
        ],
        'my-amazing-icons' => [
            'drag-handle' => 'my my-bars',
            'remove' => 'my my-times',
            'add' => 'my my-plus',
            'clone' => 'my my-files',
        ]
    ];

    public $iconSource = 'fa';

}
