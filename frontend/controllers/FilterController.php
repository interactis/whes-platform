<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;

class FilterController extends HelperController
{   
	
    public function actionContent($filters)
    {
    	$this->layout = false;
    	
    	return $this->render('/common/_previews', [
            'models' => $this->findFilterContent($filters)
        ], false, true);
    }
	
}
