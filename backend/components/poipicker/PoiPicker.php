<?php

namespace backend\components\poipicker;

use Yii;
use yii\db\Expression;
use yii\widgets\InputWidget;
use common\models\Poi;

class PoiPicker extends InputWidget
{
    
    private $_assetBundle;

    public function init()
    {
        parent::init();
        $this->registerAssetBundle();
    }

    public function run()
    {
    	$inputValue = '';
    	$coordinates = '';
    	$geom = $this->model->{$this->attribute};
    	
    	if (!empty($geom))
    	{
    		$inputValue = implode(',', $this->model->{$this->attribute});
    		$coordinates = '['. $inputValue .']';
    	}
    	
        return $this->render('view', [
        	'markerPath' => $this->_assetBundle->baseUrl .'/img/marker.svg',
        	'coordinates' => $coordinates,
        	'inputName' => ucfirst($this->model::tableName()) .'['. $this->attribute .']',
        	'inputValue' => $inputValue
        ]);
    }
	
    /**
     * Registers the asset bundle and locale
     */
    public function registerAssetBundle()
    {
        $view = $this->getView();
        $this->_assetBundle = PickerAsset::register($view);
    }
}