<?php
namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\components\ApiController;
use yii\filters\VerbFilter;
use common\models\Heritage;
 
class HeritageController extends ApiController
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
		$this->encodeResponse($this->_getHeritages());
    }
  	
  	public function actionView($id)
    {
    	$model = Heritage::findOne($id);
    	
    	if (!$model) 
    		$this->returnError(404);
    	
		$response = [
			'id' => $model->id,
			'slug' => $model->slug,
			'label' => $model->label,
			'title' => $model->name,
			'description' => $model->description,
		];
		
        $this->encodeResponse($response);
    }
    
    private function _getHeritages()
    {   
    	$response = [
    		'type' => 'FeatureCollection',
    		'features' => []
    	];
    	
    	$heritages = Heritage::find()
       		->where(['not', ['geom' => null]])
       		->andWhere([
       			'published' => true,
       			'hidden' => false
       		])
        	->all();
        
    	foreach($heritages as $heritage)
    	{
    		$response['features'][] = [
    			'type' => "Feature",
    			'properties' => [
    				'id' => $heritage->id,
    				'type' => 'heritage',
    				'label' => $heritage->label,
    				'title' => $heritage->name
    			],
    			'geometry' => [
    				'type' => 'Point',
    				'coordinates' => $heritage->geom
    			]
    		];
    	}
    	return $response;
    }
}
