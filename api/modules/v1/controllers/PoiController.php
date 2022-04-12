<?php
namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\components\ApiController;
use yii\filters\VerbFilter;
use common\models\Poi;
 
class PoiController extends ApiController
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
		$this->encodeResponse($this->_getPois());
    }
  	
  	public function actionView($id)
    {
    	$model = Phrase::findOne($id);
    	
    	if (!$model) 
    		$this->returnError(404);
    	
    	$key = 'phraseCache_'. $id;
    	$cache = Yii::$app->apiCache;
    	$data = $cache->get($key);
    	
		if ($data === false)
		{
			$response = [
				'id' => $model->id,
				'title' => $model->title,
				'description' => $model->description,
				'polygons' => $this->_getPolygons($model),
				'pois' => $this->_getPois($model)
			];
			
			$response = json_encode($response, JSON_PRETTY_PRINT);
			$cache->set($key, $response);
		}
		else
			$response = $data;
		
        $this->encodeResponse($response, false);
    }
    
    private function _getPois()
    {   
    	$response = [
    		'type' => 'FeatureCollection',
    		'features' => []
    	];
    	
    	$pois = Poi::find()
        	->joinWith('content')
       		->where(['not', ['geom' => null]])
       		->andWhere([
       			'published' => true,
       			'approved' => true,
       			'hidden' => false,
       			'archive' => false
       		])
        	->all();
        
    	foreach($pois as $poi)
    	{
    		$response['features'][] = [
    			'type' => "Feature",
    			'properties' => [
    				'id' => $poi->id,
    				'title' => $poi->title
    			],
    			'geometry' => [
    				'type' => 'Point',
    				'coordinates' => $poi->geom
    			]
    		];
    	}
    	return $response;
    }
    
  
  
}
