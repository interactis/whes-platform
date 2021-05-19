<?php
namespace frontend\components;

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
	
    public function findContent($limit = false, $offset = 0)
    {
    	$query = Content::find();
    	$query->joinWith(['article', 'poi', 'route']);
    	$query->where(['published' => true]);
    	$query->orderBy(['priority' => SORT_ASC]);
    	$query->offset($offset);
    	
    	if ($limit)
    		$query->limit($limit);
    	
    	return $query->all();
    }
}
