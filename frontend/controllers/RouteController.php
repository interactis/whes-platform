<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Route;
use yii\web\NotFoundHttpException;

/**
 * Route controller
 */
class RouteController extends Controller
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
        $model = Route::find()
        	->joinWith('content')
        	->joinWith('routeTranslations')
			->where([
				'slug' => $slug,
				Yii::$app->params['frontendType'] => true,
				'published' => true,
				'archive' => false
			])->one();
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }
    
}
