<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = 'https://ourheritage.ch/';
    public $css = [
        'css/theme.min.css?v=1.3',
    ];
    public $js = [
    	'js/map.js?v=1.3',
    	'js/popper.min.js',
    	'js/theme.js?v=1.3',
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
