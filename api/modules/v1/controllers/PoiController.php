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
    
    public function actionList($frontend)
    {
		$this->encodeResponse($this->_getPois($frontend));
    }
  	
  	public function actionView($id)
    {
    	$model = Poi::findOne($id);
    	
    	if (!$model) 
    		$this->returnError(404);
    	
		$response = [
			'id' => $model->id,
			'type' => 'poi',
			'slug' => $model->slug,
			'label' => $model->label,
			'title' => $model->title,
			'description' => Yii::$app->helpers->shortenString($model->description),
			'img' => $model->content->previewImage
		];
		
        $this->encodeResponse($response);
    }
    
    private function _getPois($frontend)
    {   
    	$response = [
    		'type' => 'FeatureCollection',
    		'features' => []
    	];
    	
    	if ($frontend != 'edu')
    		$frontend = 'visitor'; // default
    	
    	$pois = Poi::find()
        	->joinWith('content')
       		->where(['not', ['geom' => null]])
       		->andWhere([
       			'published' => true,
       			'approved' => true,
       			'hidden' => false,
       			'archive' => false,
       			$frontend => true
       		])
        	->all();
        
    	foreach($pois as $poi)
    	{
    		$response['features'][] = [
    			'type' => "Feature",
    			'properties' => [
    				'id' => $poi->id,
    				'type' => 'poi',
    				'marker' => Yii::$app->params['frontendUrl'] .'img/layout/poi-marker.svg',
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
