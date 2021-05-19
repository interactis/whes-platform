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
	
    public function findContent($heritageId = false, $featured = false, $limit = 'default', $offset = 0)
    {
    	if ($limit == 'default')
    		$limit = Yii::$app->params['showMaxContent'];
    		
    	$query = Content::find();
    	$query->joinWith(['article', 'poi', 'route']);
    	$query->where(['published' => true]);
    	
    	if ($heritageId)
    		$query->andWhere(['heritage_id' => $heritageId]);
    	
    	if ($featured)
    	{
			$query->orderBy([
				'featured' => SORT_DESC,
				'priority' => SORT_ASC,
				'created_at' => SORT_DESC
			]);
    	}
    	else
    	{
    		$query->orderBy([
				'priority' => SORT_ASC,
				'created_at' => SORT_DESC
			]);
    	}
    	
    	$query->offset($offset);
    	
    	if ($limit)
    		$query->limit($limit);
    	
    	return $query->all();
    }
}
