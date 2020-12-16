<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main app application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        'feather/css/iconfont.css',
        'apex/fonts/feather/style.min.css',
        'apex/fonts/simple-line-icons/style.css',
        'apex/fonts/font-awesome/css/font-awesome.min.css',
        'apex/vendors/css/perfect-scrollbar.min.css',
        'apex/vendors/css/prism.min.css',
        'apex/vendors/css/chartist.min.css',
        'apex/vendors/css/pickadate/pickadate.css',
        'apex/css/app.css',
        'apex/data/select2/select2.css',
        'apex/vendors/css/toastr.css',
        'css/theme-override.css',
        'css/addition-select2.css',
        'css/style-grid.css',
        'css/sticky-scrollbar.css',
        'css/sticky-table-head.css',
        'apex/vendors/css/pickadate/pickadate.css',
        'css/customdetail.css',
        'css/togglecustom.css'

    ];
    public $js = [
        'apex/vendors/js/core/jquery-3.2.1.min.js',
        // 'apex/vendors/js/core/series-label.js',
        // 'apex/vendors/js/core/exporting.js',
        // 'apex/vendors/js/core/export-data.js',
        'apex/vendors/js/core/popper.min.js',
        'apex/vendors/js/core/bootstrap.min.js',
        'apex/vendors/js/perfect-scrollbar.jquery.min.js',
        'apex/vendors/js/prism.min.js',
        'apex/vendors/js/jquery.matchHeight-min.js',
        'apex/vendors/js/screenfull.min.js',
        'apex/vendors/js/pace/pace.min.js',
        'apex/vendors/js/chartist.min.js',
        'apex/vendors/js/chartist-bar-labels.min.js',
        'apex/vendors/js/chartist-plugin-tooltip.min.js',

        'apex/vendors/js/pickadate/picker.js',
        'apex/vendors/js/pickadate/picker.date.js',
        'apex/vendors/js/pickadate/picker.time.js',
        'apex/vendors/js/pickadate/legacy.js',

        'apex/js/app-sidebar.js',
        'apex/js/notification-sidebar.js',
        'apex/js/customizer.js',
        
        // 'apex/data/select2/select2.min.js',
        'apex/vendors/js/select2.full.min.js',
        'apex/js/toastr.min.js',
        'apex/vendors/js/toastr.min.js',
        'js/addition-select2.js',
        'js/style-custom.js',
        'js/sticky-scrollbar.js',
        'js/sticky-table-head.js',
        'js/money.min.js',
        'js/custom.js',
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
    ];
}
