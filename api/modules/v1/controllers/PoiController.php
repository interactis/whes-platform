<?php
namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\components\ApiController;
use yii\filters\VerbFilter;
use common\models\Phrase;
 
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
		$this->encodeResponse($this->_getPhrases());
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
    
    private function _getPois($model)
    {    
    	$response = [
    		'type' => 'FeatureCollection',
    		'features' => []
    	];
    	
    	foreach($model->audio as $audio)
    	{
    		$response['features'][] = [
    			'type' => "Feature",
    			'properties' => [
    				'id' => $audio->id,
    				'file' => Yii::$app->params['frontendUrl'] .'audio/'. $audio->filename,
    				'description' => $audio->description
    			],
    			'geometry' => [
    				'type' => 'Point',
    				'coordinates' => $audio->poi->geom
    			]
    		];
    	}
    	return $response;
    }
    
    private function _getPolygons($model)
    {    
    	$response = [
    		'type' => 'FeatureCollection',
    		'features' => []
    	];
    	
    	foreach($model->polygons as $polygon)
    	{
    		$response['features'][] = [
    			'type' => "Feature",
    			'properties' => [
    				'id' => $polygon->id,
    				'color' => $polygon->color->code
    			],
    			'geometry' => [
    				'type' => 'MultiPolygon',
    				'coordinates' => $polygon->geom
    			]
    		];
    	}
    	return $response;
    }
  	
  	private function _getPhrases()
    {
    	$models = Phrase::find()
    		->joinWith(['phraseTranslations'])
    		->where([
				'hidden' => false,
				'language_id' => Yii::$app->params['preferredLanguageId']
    		])
    		->orderBy([
    			'order' => SORT_ASC,
    			'title' => SORT_ASC
    		])
    		->limit(200)
    		->all();
    	
    	$phrases = [];
    	foreach ($models as $model)
    	{
    		$phrases[] = [
				'id' => $model->id,
				'title' => $model->title			
			];
    	}
    	
    	return $phrases;
    }
}
