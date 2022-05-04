<?php

namespace frontend\components\map;

use Yii;
use yii\db\Expression;
use yii\base\Widget;

class Map extends Widget
{
    private $_assetBundle;

    public function init()
    {
        parent::init();
        $this->registerAssetBundle();
    }

    public function run()
    {
        return $this->render('view');
    }
	
    /**
     * Registers the asset bundle and locale
     */
    public function registerAssetBundle()
    {
        $view = $this->getView();
        $this->_assetBundle = MapAsset::register($view);
    }
}