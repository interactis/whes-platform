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
        'css/theme.min.css',
    ];
    public $js = [
    	'js/theme.js',
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
