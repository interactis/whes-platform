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
	
    public function findContent($heritageId = false, $featured = false, $q = false, $limit = 'default', $offset = 0)
    {
    	if ($limit == 'default')
    		$limit = Yii::$app->params['showMaxContent'];
    		
    	$query = Content::find()
    		->leftJoin('article', 'article.content_id = content.id')
			->leftJoin('poi', 'poi.content_id = content.id')
			->leftJoin('route', 'route.content_id = content.id');
    	
    	$query->where(['published' => true]);
    	
    	if ($heritageId)
    		$query->andWhere(['heritage_id' => $heritageId]);
    	
    	if ($q)
    	{
    		$query->leftJoin('article_translation', 'article_translation.article_id = article.id')
				->leftJoin('poi_translation', 'poi_translation.poi_id = poi.id')
				->leftJoin('route_translation', 'route_translation.route_id = route.id');
				
    		$query->andFilterWhere(['or',
    			['ilike', 'article_translation.title', $q],
    			['ilike', 'poi_translation.title', $q],
    			['ilike', 'route_translation.title', $q]
    		]);
    		
    		$query->andFilterWhere(['or',
				['article_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
				['poi_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
				['route_translation.language_id' => \Yii::$app->params['preferredLanguageId']]
			]);
    	}
    	
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
