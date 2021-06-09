<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use common\models\Content;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use \yii\web\Cookie;

class RucksackController extends HelperController
{   
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'toggle' => ['GET'],
                ],
            ],
        ];
    }
	
	
    public function actionToggle($id)
    {
    	$this->layout = false;
    	$model = $this->_findContent($id);
    	$this->_setRucksackCookie($model);    	
    	return true;
    }
    
    private function _setRucksackCookie($model)
    {
    	$id = $model->id;
    	$ids = $model->rucksackIds;
  		
    	if (($key = array_search($id, $ids)) !== false)
    	{
    		//remove from cookie
			unset($ids[$key]);
		}
    	else
    	{
    		//add to cookie
    		array_push($ids, $id);
    	}
    	
    	$this->_setCookie($ids);
    }
    
    private function _setCookie($ids)
    {
    	$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
			'name' => 'rucksack',
			'value' => implode(',', $ids),
		]));
    }
    
    private function _findContent($id)
    {
    	$model = Content::find()->where([
    		'id' => $id,
    		'published' => true
    	])->one();
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }
	
}
