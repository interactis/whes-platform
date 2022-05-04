<?php

namespace frontend\components\map;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{
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
