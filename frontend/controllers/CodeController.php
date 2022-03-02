<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use common\models\Code;
use yii\web\NotFoundHttpException;

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
		$this->setRucksackCookie($model->content);
		return $this->redirect(['rucksack/index']);
	}
    
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
}
