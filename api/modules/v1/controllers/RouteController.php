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
    
    public function actionList($type, $frontend)
    {
    	$general = false;
    	if ($type == "general")
    		$general = true;
    			
		$this->encodeResponse($this->_getRoutes($general, $frontend));
    }
  	
  	public function actionView($id)
    {
    	$model = Route::findOne($id);
    	
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
			'type' => 'route',
			'slug' => $model->slug,
			'label' => $model->label,
			'title' => $model->title,
			'description' => $description,
			'img' => $model->content->previewImage,
			'images' => $images
		];
		
        $this->encodeResponse($response);
    }
    
    private function _getRoutes($general, $frontend)
    {   
    	$response = [
    		'type' => 'FeatureCollection',
    		'features' => []
    	];
    	
    	if ($frontend != 'edu' && $frontend != 'eut')
    		$frontend = 'visitor'; // default
    	
    	$routes = Route::find()
        	->joinWith('content')
       		->where(['not', ['geom' => null]])
       		->andWhere([
       			'published' => true,
       			'approved' => true,
       			'hidden' => false,
       			'archive' => false,
       			'general' => $general,
       			$frontend => true
       		])
        	->all();
        	
        $colors = [
        	'#58E278', // green
        	'#E25858', // red
        	'#58D7E2', // blue
        	'#E2B858', // orange
        	'#BA93E2', // purble
        ];
        
        $colorIndex = 0;
    	foreach($routes as $route)
    	{
    		$response['features'][] = [
    			'type' => "Feature",
    			'properties' => [
    				'id' => $route->id,
    				'type' => 'route',
    				'title' => $route->title,
    				'color' => $colors[$colorIndex]
    			],
    			'geometry' => [
    				'type' => 'LineString',
    				'coordinates' => $route->geom
    			]
    		];
    		
    		if ($colorIndex == 4)
    		{
    			$colorIndex = 0;
    		}
    		else
    			$colorIndex = $colorIndex+1;
    	}
    	return $response;
    }
}
