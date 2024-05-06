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
    	
		switch ($model->type) {
			case Code::TYPE_INFO:
				return $this->_infoRedirect($model);
				break;
			case Code::TYPE_COLLECT:
				return $this->_collectRedirect($model);
				break;
			case Code::TYPE_URL:
				return $this->redirect(Yii::$app->params['frontendUrl']. $model->url);
				break;
		}
    }
	
	private function _collectRedirect($model)
	{
		$this->setRucksackCookie($model->content, false);
		return $this->_infoRedirect($model, true);
	}
	
	private function _infoRedirect($model, $collect = false)
	{
		$content = $model->content;
		$type = $content->typeText;
		$typeContent = $content->$type;
		$trackType = 'info';
		
		if ($collect)
		{
			$trackType = 'collect';
			Yii::$app->session->setFlash('collected', $typeContent->title);
		}
		
		return $this->redirect([
			$type .'/view',
			'slug' => $typeContent->slug,
			'trackType' => $trackType,
			'trackName' => $model->codeGroup->title,
			'trackValue' => '/'. $type .'/'. $typeContent->slug
		]);
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
