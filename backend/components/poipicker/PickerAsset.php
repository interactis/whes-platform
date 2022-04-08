<?php

namespace backend\components\poipicker;

use yii\web\AssetBundle;

class PickerAsset extends AssetBundle
{
    public $css = [
        'css/app.css',
        'css/chunk-vendors.css'
    ];

    public $js = [
    	'js/app.js',
        'js/chunk-vendors.js'
    ];

    public $depends = [];
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}
