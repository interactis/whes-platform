<?php
namespace frontend\components;

use Yii;
use yii\web\Controller;
use common\models\Content;
use common\models\Flag;
use common\models\ContentFlag;
use yii\helpers\ArrayHelper;

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
	
    public function findContent($heritageId = false, $featured = false, $q = false, $limit = 'default', $offset = 0, $contentIds = false)
    {
    	if ($limit == 'default')
    		$limit = Yii::$app->params['showMaxContent'];
    		
    	$query = Content::find()
    		->leftJoin('article', 'article.content_id = content.id')
			->leftJoin('poi', 'poi.content_id = content.id')
			->leftJoin('route', 'route.content_id = content.id');
    	
    	$query->where([
    		'published' => true,
    		'hidden' => false
    	]);
    	
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
    	
    	if ($contentIds !== false)
    	{
    		$query->andWhere(['in', 'content.id', $contentIds]);
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
    
    public function findFilterContent($filters)
    {
    	if (empty($filters))
    		return $this->findContent(false, true, false, 'default', 0);
    	
    	$flagGroups = $this->_getFlagGroups($filters);
    	
    	// First: groups with OR operator (always in results)
    	// AND ist not implemented yet for OR groups (implemented later if necessary)
    	$contentIds = $this->_getFilteredContentIds($flagGroups, 'or', 'or');
    	
    	// Second: groups with AND operator and OR filters
    	$orIds = $this->_getFilteredContentIds($flagGroups, 'and', 'or', true);
    	
    	// Third: groups with AND operator and AND filters
    	$andIds = $this->_getFilteredContentIds($flagGroups, 'and', 'and', true, 'filter');
    	
    	$filteredIds = [];
    	if (!empty($orIds) && !empty($andIds))
    	{
    		$filteredIds = $this->_filterIds(2, array_merge($orIds, $andIds));
    	}
    	else
    	{
    		if (!empty($orIds))
    			$filteredIds = $orIds;
    		
    		if (!empty($andIds))
    			$filteredIds = $andIds;
    	}
    	
    	$contentIds = array_unique(array_merge($contentIds, $filteredIds));
    	
    	return $this->findContent(false, true, false, 'default', 0, $contentIds);
    }
    
    private function _getFilteredContentIds($groups, $groupOperator, $flagOperator, $filterIds = false, $countType = 'group')
    {
    	$contentIds = [];
    	$filterCount = 0;
    	if (isset($groups[$groupOperator]))
    	{
			foreach ($groups[$groupOperator] as $group)
			{
				if (isset($group[$flagOperator]))
				{
					$flagIds = $group[$flagOperator];
					$contentIds = array_merge($contentIds, $this->_getContentIds($flagIds));
					$filterCount = $filterCount+1;
				}
			}
			
			if ($filterIds)
			{
				$count = $filterCount;
				if ($countType == 'group')
					$count = count($groups[$groupOperator]);
				
				$contentIds = $this->_filterIds($count, $contentIds);
			}
    	}
    	return $contentIds;
    }
    
    private function _filterIds($total, $ids)
    {
    	$counts = array_count_values($ids);
    	
    	$sameIds = [];
    	foreach ($counts as $id => $count)
    	{
    		if ($count == $total)
    			array_push($sameIds, $id);
    	}
    	
    	return $sameIds;
    }
    
    private function _getContentIds($flagIds)
    {
    	$models = ContentFlag::find()
    		->where(['in', 'flag_id', $flagIds])
    		->all();
    	
    	return array_values(ArrayHelper::map($models, 'id', 'content_id'));
    }   
    
    private function _getFlagGroups($filters)
    {
    	$ids = explode(',', $filters);
    	$flags = $this->_getFlags($ids);
    	
    	$flagGroups = [];
    	foreach($flags as $flag)
    	{
    		$flagGroup = $flag->flagGroup;
    		
    		if (isset($flagGroups[$flagGroup->operator]))
    		{	
    			if (isset($flagGroups[$flagGroup->operator][$flagGroup->id][$flag->operator]))
    			{
    				array_push($flagGroups[$flagGroup->operator][$flagGroup->id][$flag->operator], $flag->id);
    			}
    			else
    				$flagGroups[$flagGroup->operator][$flagGroup->id][$flag->operator] = [$flag->id];
    		}
    		else
    		{			
    			$flagGroups[$flagGroup->operator][$flagGroup->id] = [$flag->operator => [$flag->id]];
    		}
    	}
    	
		 /* Result array example:
		 Array (
			[and] => Array (
				[2] => Array (
					[or] => Array (
						[0] => 5
						[1] => 12
					)
					[and] => Array (
						[0] => 17
					)
				)
				[3] => Array (
					[or] => Array (
						[0] => 9
						[1] => 8
					)
				)
			)
			[or] => Array (
				[4] => Array (
					[or] => Array (
						[0] => 11
					)
				)
			)
		)
		*/
    	
    	return $flagGroups;
    }
    
	private function _getFlags($ids)
	{
		return Flag::find()
			->where(['in', 'id', $ids])
			->all();
	}
}
