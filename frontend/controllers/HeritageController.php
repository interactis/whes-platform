<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Heritage;
use yii\web\NotFoundHttpException;

/**
 * Heritage controller
 */
 
class HeritageController extends Controller
{
    public function actionView($slug)
    {
    	return $this->render('view', [
    		'model' => $this->findModel($slug),
    	]);
    }
 
 	protected function findModel($slug)
    {
        $model = Heritage::find()
        	->joinWith('heritageTranslations')
			->where([
				'slug' => $slug,
				'published' => true
			])->one();
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }

}
