<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use common\models\Flag;
use common\models\Content;

class FilterController extends HelperController
{   
    public function actionContent($filters)
    {
    	$ids = explode(',', $filters);
    	$flags = $this->_getFlags($ids);
    	
    	$flagGroups = [];
    	foreach($flags as $flag)
    	{
    		$flagGroup = $flag->flagGroup;
    		
    		if (isset($flagGroups[$flag->flagGroup->id]))
    		{	
    			if (isset($flagGroups[$flag->flagGroup->id]['items'][$flag->operator]))
    			{
    				array_push($flagGroups[$flag->flagGroup->id]['items'][$flag->operator], $flag->id);
    			}
    			else
    				$flagGroups[$flag->flagGroup->id]['items'][$flag->operator] = [$flag->id];
    		}
    		else
    		{			
    			$flagGroups[$flag->flagGroup->id] = [
					'operator' => $flagGroup->operator,
					'items' => [
						$flag->operator => [$flag->id]
					]
				];
    		}
    	}
    	
    	$models = $this->findContent(false, true, false, 'default', 0, $flagGroups);
    	
    	foreach ($models as $model)
    	{
    		echo $model->id .'<br />';
    	}
    	exit;
    	
    	return $this->render('index', [
    		'models' => $models,
    		'q' => $q
    	]);
    }

	private function _getFlags($ids)
	{
		return Flag::find()
			->where(['in', 'id', $ids])
			->all();
	}
	
}
