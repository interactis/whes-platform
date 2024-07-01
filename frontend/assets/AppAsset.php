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
   	//public $baseUrl = 'http://ourheritage:8888/';
    public $css = [
        'css/theme.min.css?v=1.81',
    ];
    public $js = [
    	'js/map.js?v=1.81',
    	'js/popper.min.js',
    	'js/theme.js?v=1.81',
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
