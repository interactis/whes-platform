<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use yii\web\NotFoundHttpException;

class MapController extends HelperController
{   
    public function actionIndex()
    {
    	return $this->render('index');
    }
}
