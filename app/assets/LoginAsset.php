<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "vendorAsests/bootstrap/dist/css/bootstrap.min.css",
        "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css",
        "css/logincss/my-login.css",

    ];
    public $js = [
    "https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js",
    "js/loginjs/my-login.js",
    

    ];
    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];


    public $iconSource = 'fa';

}
