<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Heritage controller
 */
class HeritageController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
    
}
