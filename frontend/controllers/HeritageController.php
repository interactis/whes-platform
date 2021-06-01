<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use common\models\Heritage;
use yii\web\NotFoundHttpException;

/**
 * Heritage controller
 */
 
class HeritageController extends HelperController
{
    public function actionView($slug)
    {
    	$model = $this->findModel($slug);
    	$filters = $this->getFilterCookie();
    	
    	return $this->render('view', [
    		'model' => $model,
    		'content' => $this->findFilterContent($filters, $model->id, false),
    		'filters' => explode(',', $filters)
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
