<?php

namespace backend\components\poiwidget;

use yii\web\AssetBundle;

class PoiAsset extends AssetBundle
{
    public $css = [
        'css/jquery-ui.min.css',
        'css/map.css',
    ];

    public $js = [
        'js/jquery-ui.min.js',
        'js/map.js',
        '//api3.geo.admin.ch/loader.js?lang=en'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}
