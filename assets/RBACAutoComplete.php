<?php

namespace app\assets;

use yii\web\AssetBundle;

class RBACAutoComplete extends AssetBundle
{
    //public $sourcePath = '@mdm/admin/assets';
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/rbac/jquery-ui.css',
    ];

    public $js = [
        'js/rbac/jquery-ui.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
