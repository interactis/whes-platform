<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Poi controller
 */
class PoiController extends Controller
{

	public $defaultAction = 'view';

    public function actionView()
    {
        return $this->render('view');
    }
    
}
