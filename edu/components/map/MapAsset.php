<?php

namespace edu\components\map;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
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
    
    public $publishOptions = [
		'forceCopy' => true,
	];
}
