<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Heritage controller
 */
class HeritageController extends Controller
{

	public $defaultAction = 'view';
	
    public function actionView()
    {
        return $this->render('view');
    }
    
}
