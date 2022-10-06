<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use common\models\Heritage;
use common\models\Poi;
use common\models\Route;

class MapController extends HelperController
{   

    public function actionIndex()
    {
    	return $this->render('index', [
    		'initialItem' => false,
    		'translations' => $this->_getTranslations()
    	]);
    }
	
	public function actionHeritage($id)
    {
    	$model = $this->_getInitialHeritageModel($id);
    	
    	return $this->render('index', [
    		'initialItem' => 'heritage-'. $model->id,
    		'translations' => $this->_getTranslations()
    	]);
    }
    
    public function actionPoi($id)
    {
    	$model = $this->_getInitialContentModel('poi', $id);
    	
    	return $this->render('index', [
    		'initialItem' => 'poi-'. $model->id,
    		'translations' => $this->_getTranslations()
    	]);
    }
    
    public function actionRoute($id)
    {
    	$model = $this->_getInitialContentModel('route', $id);
    	
    	return $this->render('index', [
    		'initialItem' => 'route-'. $model->id,
    		'translations' => $this->_getTranslations()
    	]);
    }
	
	private function _getInitialHeritageModel($id)
	{
		$model = Heritage::find()
			->where([
       			'id' => $id,
       			'hidden' => false
       		])
       		->andWhere(['not', ['geom' => null]])
        	->one();
        
        if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
	}
	
	private function _getInitialContentModel($type, $id)
	{
		$className = '\\common\models\\'. ucfirst($type);
		$className = new $className();
		
		$model = $className::find()
			->joinWith('content')
       		->where([
       			$type .'.id' => $id,
       			'hidden' => false
       		])
       		->andWhere(['not', ['geom' => null]])
        	->one();
        
        if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
	}
	
	private function _getTranslations()
    {
    	return '{
			"display": "'. Yii::t('app', 'Display') .'",
			"view": "'. Yii::t('app', 'View') .'",
			"pointOfInterest": "'. Yii::t('app', 'Points of interest') .'",
			"routes": "'. Yii::t('app', 'Routes') .'",
			"perimeter": "'. Yii::t('app', 'World Heritage perimeters') .'",
			"hikingTrailNetwork": "'. Yii::t('app', 'Hiking trail network') .'",
			"publicTransport": "'. Yii::t('app', 'Public transports') .'",
			"close": "'. Yii::t('app', 'Close') .'",
			"learnMore": "'. Yii::t('app', 'Learn more') .'"
		}';
    }
}
