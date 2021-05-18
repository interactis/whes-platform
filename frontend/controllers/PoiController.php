<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Poi;
use yii\web\NotFoundHttpException;

/**
 * Poi controller
 */
class PoiController extends Controller
{
	
    public function actionView($slug)
    {
    	$model = $this->findModel($slug);
    	$content = $model->content;
    	$heritage = $content->heritage;
    	
        return $this->render('view', [
    		'model' => $this->findModel($slug),
    		'content' => $content,
    		'heritage' => $heritage
    	]);
    }
    
    protected function findModel($slug)
    {
        $model = Poi::find()
        	->joinWith('content')
        	->joinWith('poiTranslations')
			->where([
				'slug' => $slug,
				'published' => true
			])->one();
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }
    
}
