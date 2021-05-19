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
	
    public function findContent()
    {
    	$query = Content::find();
    	$query->joinWith(['article', 'poi', 'route']);
    	$query->where(['published' => true]);
    	//$query->leftJoin('application_translation', 'application_translation.application_id = application.id');
    	//$query->leftJoin('language', 'application_translation.language_id = language.id');
    	//$query->where(['published' => true, 'language.code' => Yii::$app->language]);
    		
    	
    	/*
    	$query->orderBy(['order' => SORT_ASC])->offset($offset);
    	
    	if ($limit)
    		$query->limit($limit);
    	*/
    	
    	return $query->all();
    }
}
