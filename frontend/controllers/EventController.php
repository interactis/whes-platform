<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Event;
use yii\web\NotFoundHttpException;

/**
 * Event controller
 */
class EventController extends Controller
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
        $model = Event::find()
        	->joinWith('content')
        	->joinWith('eventTranslations')
			->where([
				'slug' => $slug,
				'published' => true,
				'archive' => false
			])->one();
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }
    
}
