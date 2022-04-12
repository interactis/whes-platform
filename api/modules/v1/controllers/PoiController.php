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
    				'type' => 'poi',
    				'label' => $poi->label,
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
