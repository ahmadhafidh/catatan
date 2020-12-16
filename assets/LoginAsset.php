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
        'apex/css/app.min.css',
        'apex/fonts/feather/style.min.css',
        'apex/fonts/font-awesome/css/font-awesome.min.css',
        'apex/fonts/simple-line-icons/style.min.css',
        'apex/vendors/css/perfect-scrollbar.min.css',
        'apex/vendors/css/prism.min.css',
        'css/theme-override.css',
    ];
    public $js = [
        "apex/vendors/js/core/popper.min.js", 
        "apex/vendors/js/core/bootstrap.min.js", 
        "apex/vendors/js/perfect-scrollbar.jquery.min.js", 
        "apex/vendors/js/prism.min.js", 
        "apex/vendors/js/jquery.matchHeight-min.js", 
        "apex/vendors/js/screenfull.min.js", 
        "apex/vendors/js/pace/pace.min.js", 
        "apex/js/app-sidebar.js", 
        "apex/js/notification-sidebar.js", 
        "apex/js/customizer.js" 
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
