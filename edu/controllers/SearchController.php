<?php
namespace edu\controllers;

use Yii;
use edu\components\HelperController;
use yii\web\NotFoundHttpException;

class SearchController extends HelperController
{   
    public function actionIndex($q)
    {
    	return $this->render('index', [
    		'models' => $this->findContent(false, true, $q, 30),
    		'q' => $q
    	]);
    }
    
}
