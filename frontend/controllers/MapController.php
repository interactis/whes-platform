<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use common\models\Poi;
use common\models\Route;

class MapController extends HelperController
{   

	private $_selectTypes = ['poi', 'route'];
	
    public function actionIndex()
    {
    	$model = false;
    	if (isset($_GET['select']) && isset($_GET['id']) && is_numeric($_GET['id']))
		{
			if (is_numeric($_GET['id']) && in_array($_GET['select'], $this->_selectTypes))
				$model = $this->_getInitialModel($_GET['select'], $_GET['id']);
		}
		
    	return $this->render('index', [
    		'model' => $model
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
	
	private function _getInitialModel($type, $id)
	{
		$className = '\\common\models\\'. ucfirst($type);
		$className = new $className();
		
		$model = $className::find()
			->joinWith('content')
       		->andWhere([
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
