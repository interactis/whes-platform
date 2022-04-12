<?php
namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\components\ApiController;
use yii\filters\VerbFilter;
use common\models\Route;
 
class RouteController extends ApiController
{
    public $authRequried = false;
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['get'],
                    'view' => ['get'],
                ]
            ]
        ];
    }
    
    public function actionList()
    {
		$this->encodeResponse($this->_getRoutes());
    }
  	
  	public function actionView($id)
    {
    	$model = Route::findOne($id);
    	
    	if (!$model) 
    		$this->returnError(404);
    	
		$response = [
			'id' => $model->id,
			'slug' => $model->slug,
			'label' => $model->label,
			'title' => $model->title,
			'description' => $model->description,
		];
		
        $this->encodeResponse($response);
    }
    
    private function _getRoutes()
    {   
    	$response = [
    		'type' => 'FeatureCollection',
    		'features' => []
    	];
    	
    	$routes = Route::find()
        	->joinWith('content')
       		->where(['not', ['geom' => null]])
       		->andWhere([
       			'published' => true,
       			'approved' => true,
       			'hidden' => false,
       			'archive' => false
       		])
        	->all();
        
    	foreach($routes as $route)
    	{
    		$response['features'][] = [
    			'type' => "Feature",
    			'properties' => [
    				'id' => $route->id,
    				'type' => 'route',
    				'label' => $route->label,
    				'title' => $route->title
    			],
    			'geometry' => [
    				'type' => 'LineString',
    				'coordinates' => $route->geom
    			]
    		];
    	}
    	return $response;
    }
}
