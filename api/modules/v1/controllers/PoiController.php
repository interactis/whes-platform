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
    	
    	if (isset($_GET['fullDescription']) && $_GET['fullDescription'] == 1)
		{
    		$description = $model->description;
    	}
    	else 
    		$description = Yii::$app->helpers->shortenString($model->description);
    	
    	$content = $model->content;
    	$images = [];
    	foreach($content->media as $media)
    	{
			$images[] = [
				'url' => $media->getImageUrl(600),
				'alt' => $media->title
			];
    	}
    	
		$response = [
			'id' => $model->id,
			'type' => 'poi',
			'slug' => $model->slug,
			'label' => $model->label,
			'title' => $model->title,
			'description' => $description,
			'img' => $content->previewImage,
			'images' => $images
		];
		
        $this->encodeResponse($response);
    }
    
    private function _getPois($frontend)
    {   
    	$response = [
    		'type' => 'FeatureCollection',
    		'features' => []
    	];
    	
    	if ($frontend != 'edu' && $frontend != 'eut')
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
        
        switch ($frontend)
        {
			case 'edu':
				$frontendUrl = Yii::$app->params['eduUrl'];
				break;
			case 'eut':
				$frontendUrl = Yii::$app->params['eutUrl'];
				break;
			default:
				 $frontendUrl = Yii::$app->params['frontendUrl'];
		}
        
    	foreach($pois as $poi)
    	{
    		$response['features'][] = [
    			'type' => "Feature",
    			'properties' => [
    				'id' => $poi->id,
    				'type' => 'poi',
    				'marker' => $frontendUrl .'img/layout/poi-marker.svg',
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
