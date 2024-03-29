<?php
namespace frontend\components;

use Yii;
use yii\web\Controller;
use common\models\Content;
use common\models\Flag;
use common\models\ContentFlag;
use yii\helpers\ArrayHelper;
use \yii\web\Cookie;

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
	
	public function setRucksackCookie($model, $toggle = true)
    {
    	$id = $model->id;
    	$ids = Yii::$app->helpers->getRucksackIds();
  		
    	if (($key = array_search($id, $ids)) !== false)
    	{
			if ($toggle)
				unset($ids[$key]); //remove from cookie
		}
    	else
    	{
    		//add to cookie
    		array_push($ids, $id);
    	}
    	
    	$this->_setCookie($ids);
    }
    
    private function _setCookie($ids)
    {
    	$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
			'name' => 'rucksack',
			'value' => implode(',', $ids),
		]));
    }
	
    public function findContent($heritageId = false, $featured = false, $q = false, $limit = 'default', $offset = 0, $contentIds = false)
    {
    	if ($limit == 'default')
    		$limit = Yii::$app->params['showMaxContent'];
    		
    	$query = Content::find()
    		->leftJoin('article', 'article.content_id = content.id')
			->leftJoin('poi', 'poi.content_id = content.id')
			->leftJoin('route', 'route.content_id = content.id')
			->leftJoin('event', 'event.content_id = content.id')
			->leftJoin('article_translation', 'article_translation.article_id = article.id')
			->leftJoin('poi_translation', 'poi_translation.poi_id = poi.id')
			->leftJoin('route_translation', 'route_translation.route_id = route.id')
			->leftJoin('event_translation', 'event_translation.event_id = event.id');
    	
    	$query->where([
    		Yii::$app->params['frontendType'] => true,
    		'published' => true,
    		'hidden' => false,
    		'approved' => true,
    		'archive' => false
    	]);
    	
    	if ($heritageId)
    		$query->andWhere(['heritage_id' => $heritageId]);
			
		$query->andFilterWhere(['or',
			['article_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
			['poi_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
			['route_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
			['event_translation.language_id' => \Yii::$app->params['preferredLanguageId']]
		]);
    	
    	if ($q)
    	{
    		$query->andFilterWhere(['or',
    			['ilike', 'article_translation.title', $q],
    			['ilike', 'poi_translation.title', $q],
    			['ilike', 'route_translation.title', $q],
    			['ilike', 'event_translation.title', $q]
    		]);
    	}
    	
    	if ($contentIds !== false)
    	{
    		$query->andWhere(['in', 'content.id', $contentIds]);
    	}
    	
    	$query->andFilterWhere(['OR', 
    		['>=', 'event.to', date('Y.m.d')],
    		['!=', 'content.type', Content::TYPE_EVENT],
    	]);
    	
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
    
    public function findFilterContent($filters, $heritageId = false, $featured = true, $limit = 'default', $offset = 0)
    {
    	if (empty($filters))
    		return $this->findContent($heritageId, $featured, false, $limit, $offset);
    	    	
    	$flagGroups = $this->_getFlagGroups($filters);
    	$contentIds = $this->_getFilteredContentIds($flagGroups);
    	return $this->findContent($heritageId, $featured, false, $limit, $offset, $contentIds);
    }
    
    public function totalContent($filters, $heritageId = false, $featured = true)
    {
    	$models = $this->findFilterContent($filters, $heritageId, $featured, false);
		return count($models);
    }
    
    public function showMoreBtn($totalContent, $offset = 0)
    {
    	if ($totalContent > (Yii::$app->params['showMaxContent'] + $offset))
    	{
    		return true;
    	}
    	else
    		return false;
    }
    
    public function getFilterCookie($explode = false)
    {
    	$cookies = Yii::$app->request->cookies;
    	$filters = $cookies->get('filters');
    	
    	if ($filters && !empty($filters->value))
    	{
    		if ($explode)
    		{
    			return explode(',', $filters);
    		}
    		else
    			return $filters;
    	}
    	else
    		return false;
    }
    
    private function _getFilteredContentIds($groups)
    {	
    	//groups OR
        $contentIds = [];
		if (isset($groups['or']))
		{
			foreach ($groups['or'] as $group)
			{
				$filterCount = 0;
				$groupContentIds = [];
				if (isset($group['or']))
				{
					$flagIds = $group['or'];
					$groupContentIds = array_merge($groupContentIds, $this->_getContentIds($flagIds));
					$filterCount = 1; // all OR filters count as 1
				}
			
				if (isset($group['and']))
				{
					$flagIds = $group['and'];
					$groupContentIds = array_merge($groupContentIds, $this->_getContentIds($flagIds));
					$filterCount = $filterCount + count($flagIds);
				}
			
				if ($filterCount > 1)
					$groupContentIds = $this->_filterIds($filterCount, $groupContentIds);
			
				$contentIds = array_merge($contentIds, $groupContentIds);
			}
		}
		
		//groups AND
		if (isset($groups['and']))
		{
			$filterSet = false;
			foreach ($groups['and'] as $group)
			{
				$filterCount = 0;
				$groupContentIds = [];
				if (isset($group['or']))
				{
					$flagIds = $group['or'];
					$groupContentIds = array_merge($groupContentIds, $this->_getContentIds($flagIds));
					$filterCount = 1; // all AND filters count as 1
				}
			
				if (isset($group['and']))
				{
					$flagIds = $group['and'];
					$groupContentIds = array_merge($groupContentIds, $this->_getContentIds($flagIds));
					$filterCount = $filterCount + count($flagIds);
				}
			
				if ($filterSet)
				{
					$groupContentIds = $this->_filterIds($filterCount, $groupContentIds);
					$allContentIds = array_merge($groupContentIds, $contentIds);
					$counts = array_count_values($allContentIds);
					
					$contentIds = [];
					foreach ($counts as $id => $count)
					{
						if ($count > 1)
							array_push($contentIds, $id);
					}
				}
				else
				{
					$filterSet = true;
					$contentIds = $groupContentIds;
				}
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
	
	public function getHeritageFilters($heritage)
    {
    	$flagCacheName = $heritage->flagCacheName;
    	//Yii::$app->cache->delete($flagCacheName); // reset
    	
    	if ($flagStr = Yii::$app->cache->get($flagCacheName))
    	{
    		$flagIds = explode(',', $flagStr);
    	}
    	else
    	{
    		$models = $this->_findActiveContent($heritage->id);
    		$flagIds = $this->_getFlagIds($models);
    		Yii::$app->cache->set($flagCacheName, implode(',', $flagIds), 3600*4); // 4 hours
    	}
    	
    	return $flagIds;
    }
    
    private function _findActiveContent($heritageId)
    {	
    	$query = Content::find()
    		->leftJoin('article', 'article.content_id = content.id')
			->leftJoin('poi', 'poi.content_id = content.id')
			->leftJoin('route', 'route.content_id = content.id')
			->leftJoin('event', 'event.content_id = content.id')
			->leftJoin('article_translation', 'article_translation.article_id = article.id')
			->leftJoin('poi_translation', 'poi_translation.poi_id = poi.id')
			->leftJoin('route_translation', 'route_translation.route_id = route.id')
			->leftJoin('event_translation', 'event_translation.event_id = event.id');
    	
    	$query->where([
    		'heritage_id' => $heritageId,
    		'published' => true,
    		'hidden' => false,
    		'approved' => true,
    		'archive' => false
    	]);
    	
		$query->andFilterWhere(['or',
			['article_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
			['poi_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
			['route_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
			['event_translation.language_id' => \Yii::$app->params['preferredLanguageId']]
		]);
    	
    	$query->andFilterWhere(['OR', 
    		['>=', 'event.to', date('Y.m.d')],
    		['!=', 'content.type', Content::TYPE_EVENT],
    	]);
    	
    	return $query->all();
    }
    
    private function _getFlagIds($models) {
    	$flagIds = [];
    	foreach ($models as $model)
    	{
    		$contentFlags = $model->contentFlags;
    		
    		foreach ($contentFlags as $contentFlag)
    		{
				if (!in_array($contentFlag->flag_id, $flagIds))
					$flagIds[] = $contentFlag->flag_id;
    		}
    	}
    	
    	return $flagIds;
    }
}
