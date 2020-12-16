<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main app application asset bundle.
 */
class ChartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/highcharts.js',
        'js/export-data.js',
        'js/accessibility.js',
    ];
    public $depends = [];
}
