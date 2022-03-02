<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use common\models\Code;
use yii\web\NotFoundHttpException;
use \yii\web\Cookie;

class CodeController extends HelperController
{   

	public function actionIndex($code)
    {
    	$model = $this->_findCode($code);
    	
    	if ($model->type == Code::TYPE_INFO)
    	{
    		return $this->_infoRedirect($model);
    	}
    	else
    		return $this->_collectRedirect($model);
    }
	
	private function _infoRedirect($model)
	{
		$content = $model->content;
		$type = $content->typeText;
		$typeContent = $content->$type;
		return $this->redirect([$type .'/view', 'slug' => $typeContent->slug]);
	}
	
	private function _collectRedirect($model)
	{
		$content = $model->content;
		$type = $content->typeText;
		$typeContent = $content->$type;
		
		echo 'Collect';
		exit;
	}
   
    /*
    private function _setRucksackCookie($model)
    {
    	$id = $model->id;
    	$ids = Yii::$app->helpers->getRucksackIds();
  		
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
    */
    
    private function _findCode($code)
    {
    	$model = Code::find()->where([
    		'code' => $code,
    		'active' => true
    	])->one();
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }
    
    /*
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
	*/    
}
