<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use common\models\Flag;
use common\models\ContentFlag;
use yii\helpers\ArrayHelper;

class FilterController extends HelperController
{   
    public function actionContent($filters)
    {
    	$models = $this->findFilterContent($filters);
    	
    	foreach ($models as $model)
    	{
    		$type = $model->typeText;
    		echo $model->{$type}->title .'<br />';
    	}
    	exit;
    	
    	return $this->render('index', [
    		'models' => $models,
    		'q' => $q
    	]);
    }
    
    
    public function findFilterContent($filters)
    {
    	$flagGroups = $this->_getFlagGroups($filters);
    	$contentIds = [];
    	
    	// First: groups with OR operator (always in results)
    	foreach ($flagGroups['or'] as $group)
    	{
    		// AND not implemented yet for OR groups (implemented later if necessary)
    			
    		if (isset($group['or']))
    		{
    			$flagIds = $group['or'];
    			$contentIds = array_merge($contentIds, $this->_getContentIds($flagIds));
    		}
    	}
    	
    	// Second: groups with AND operator and OR filters
    	$orIds = [];
    	foreach ($flagGroups['and'] as $group)
    	{
    		
    		if (isset($group['or']))
    		{
    			$flagIds = $group['or'];
    			$orIds = array_merge($orIds, $this->_getContentIds($flagIds));
    		}
    	}
    	
    	$filteredOrIds = $this->_filterIds(count($flagGroups['and']), $orIds);
    	
    	
    	// Third: groups with AND operator and AND filters
    	$andIds = [];
    	$andFilterCount = 0;
    	foreach ($flagGroups['and'] as $group)
    	{	
    		if (isset($group['and']))
    		{
    			$flagIds = $group['and'];
    			$andIds = array_merge($andIds, $this->_getContentIds($flagIds));
    			$andFilterCount = $andFilterCount+1;
    		}
    	}
    	
    	$filteredAndIds = $this->_filterIds($andFilterCount, $andIds);
    	
    	$filteredIds = $this->_filterIds(2, array_merge($filteredOrIds, $filteredAndIds));
    	
    	$contentIds = array_unique(array_merge($contentIds, $filteredIds));
    	
    	return $this->findContent(false, true, false, 'default', 0, $contentIds);
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
    
    /* _getFlagGroups()
     * Result array example:
     
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
    	
    	return $flagGroups;
    }
    
	private function _getFlags($ids)
	{
		return Flag::find()
			->where(['in', 'id', $ids])
			->all();
	}
	
}
