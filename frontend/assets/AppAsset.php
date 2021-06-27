<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/theme.min.css?v=1.0',
    ];
    public $js = [
    	'js/map.js?v=1.0',
    	'js/popper.min.js',
    	'js/theme.js?v=1.0',
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
