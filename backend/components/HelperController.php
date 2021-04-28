<?php
namespace backend\components;

use Yii;
use yii\web\Controller;

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
	
	public function isOwnerOrAdmin()
    {   
    	$user = Yii::$app->user->identity;
    	
    	if ($user->isAdmin())
    	{
    		return true;
    	}
    	else
    	{
    		if ($user->heritage_id == Yii::$app->request->get('id'))
    			return true;
    	}
    	
    	return false;
    }
    
}
