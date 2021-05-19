<?php

namespace frontend\components\mapwidget;

use yii\web\AssetBundle;


class MapAsset extends AssetBundle
{
    public $css = [
        'css/nouislider.min.css',
    ];

    public $js = [
        'js/nouislider.min.js',
        '//api3.geo.admin.ch/loader.js?lang=en&version=3.18.2',
        'js/mapPlugin.js',
        'js/mapNavigation.js'
    ];

    public $publishOptions = [
        'forceCopy' => true
    ];

    public $depends = [
        'frontend\assets\AppAsset',
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
