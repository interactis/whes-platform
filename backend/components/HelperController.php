<?php
namespace backend\components;

use Yii;
use yii\web\Controller;
use common\models\Content;

class HelperController extends Controller
{

	public function init()
	{    		        
        parent::init();
    }
    
    public function beforeAction($action)
	{

	    if (!parent::beforeAction($action))
	    {
	        return false;
	    }
	    

	    return true; // or false to not run the action
	}
	
	public function isOwnerOrAdmin($heritageId)
    {   
    	$user = Yii::$app->user->identity;
    	
    	if ($user->isAdmin())
    	{
    		return true;
    	}
    	else
    	{
    		if ($user->heritage_id == $heritageId)
				return true;
    	}
    	
    	return false;
    }
    
    public function newContentModel($type)
    {
    	$model = new Content();
    	$model->type = $type;
    	
    	$user = Yii::$app->user->identity;
		if ($user->isAdmin())
    		$model->approved = true;
    		
    	if ($user->isEditor())
    		$model->heritage_id = $user->heritage_id;
    	
    	return $model;		
    }
    
    public function setPointGeom($post, $model)
    {
    	$type = ucfirst($model->tableName());
        $geom = (isset($post[$type]['geom'])) ? $post[$type]['geom'] : false;
        
        if ($geom)
            $model->setGeom(array_map('intval', explode(',', $post[$type]['geom'])));
        
        unset($post[$type]['geom']);
        return $post;
    }
    
    private function _getItems($fileName)
    {
    	$xml = simplexml_load_file($fileName);
    	
    	$items = [];
    	foreach ($xml->trk->trkseg->trkpt as $item)
    	{
    		$attr = $attr = $item->attributes();
			
    		$items[] = [
    			'lat' => $attr->lat,
    			'lon' => $attr->lon,
    			'time' => $item->time
    		];
    	}
    	
		return $items;
    }
    
}
