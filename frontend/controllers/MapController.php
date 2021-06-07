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
    	return $this->render('index');
    }
	
	public function actionHeritage($id)
    {
    	return $this->render('heritage', [
    		'model' => $this->_getInitialHeritageModel($id)
    	]);
    }
    
    public function actionPoi($id)
    {
    	return $this->render('poi', [
    		'model' => $this->_getInitialContentModel('poi', $id)
    	]);
    }
    
    public function actionRoute($id)
    {
    	return $this->render('route', [
    		'model' => $this->_getInitialContentModel('route', $id)
    	]);
    }
    
    public function actionGetAllMarkers()
	{
		$data = $this->_getAllMarkers();
		 
		$status_header = 'HTTP/1.1 200 OK';
		$content_type="application/json; charset=utf-8";
		header($status_header);
		header('Content-type: ' . $content_type);
		return json_encode($data, JSON_PRETTY_PRINT);
	}
	
	public function actionGetInfoModal()
	{
		$request = Yii::$app->request->get();
		$tableName = $request['type'];
		$modelName = ucfirst($tableName);
		$model = Poi::findOne([
			'id' => $request['id']
		]);
		
		if ($model !== null)
		{
			$this->layout = false;
			return $this->render('_infoModal.php', [
				'model' => $model,
				'modelName' => $tableName,
				'isMapModal' => true
			]);
		}
		
		return null;
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
	
    private function _getAllMarkers()
    {
        $pois = Poi::find()
        	->joinWith('content')
       		->where(['not', ['geom' => null]])
       		->andWhere(['hidden' => false])
        	->all();
        
        $routes = Route::find()
        	->joinWith('content')
       		->where(['not', ['geom' => null]])
       		->andWhere(['hidden' => false])
        	->all();
    	
        return [
        	'pois' => ArrayHelper::toArray($pois, [
				'common\models\Poi' => [
					'id',
					'geom',
				]
			]),
        	'routes' => ArrayHelper::toArray($routes, [
				'common\models\Route' => [
					'id',
					'geom',
				]
			])
        ];
    }
}
