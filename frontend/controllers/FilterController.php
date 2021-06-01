<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use \yii\web\Cookie;

class FilterController extends HelperController
{   
	
    public function actionContent($filters)
    {
    	$this->layout = false;
    	
    	$this->_setFilterCookie($filters);
    	
    	return $this->render('/common/_previews', [
            'models' => $this->findFilterContent($filters)
        ], false, true);
    }
    
    private function _setFilterCookie($filters)
    {
    	$cookies = Yii::$app->response->cookies;
    	$cookies->add(new \yii\web\Cookie([
			'name' => 'filters',
			'value' => $filters,
		]));
    }
	
}
