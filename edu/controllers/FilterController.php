<?php
namespace edu\controllers;

use Yii;
use edu\components\HelperController;
use common\models\Heritage;
use \yii\web\Cookie;

class FilterController extends HelperController
{   
	
    public function actionContent($filters, $heritageId, $featured, $limit, $offset)
    {
    	$this->layout = false;
    	$this->_setGlobalFilters($filters, $heritageId);
    	
    	return $this->render('/common/_previews', [
            'models' => $this->findFilterContent($filters, $heritageId, $featured, $limit, $offset)
        ], false, true);
    }
    
    private function _setGlobalFilters($filters, $heritageId)
    {
    	$globalFilters = $filters;
    	
    	if ($heritageId)
    	{
    		$heritage = $this->_findHeritage($heritageId);
			$globalFiltersSet = $this->getFilterCookie(true);
			
			$heritageFiltersSet = false;
			if (!empty($filters))
				$heritageFiltersSet = explode(',', $filters);
			
			if (empty($globalFiltersSet))
			{
				$globalFilters = implode(',', $heritageFiltersSet);
			}
			else
			{
				if (!$heritageFiltersSet)
				{	
					$combinded = $globalFiltersSet;
				}
				else
					$combinded = array_unique(array_merge($globalFiltersSet, $heritageFiltersSet));
			
				// remove the ones that have not been selected in heritage filter
				$remove = [];
				$heritageFilters = $this->getHeritageFilters($heritage);
				
				if (!$heritageFiltersSet)
					$heritageFiltersSet = [];
				
				foreach ($heritageFilters as $heritageFilter)
				{
					if (!in_array($heritageFilter, $heritageFiltersSet))
						$remove[] = $heritageFilter;	
				}
				$removed = array_diff($combinded, $remove);
				$globalFilters = implode(',', $removed);
			}
    	}
    	
		$this->_setFilterCookie($globalFilters);
    }
    
    private function _findHeritage($id)
    {
        return Heritage::findOne($id);
    }
    
    private function _setFilterCookie($filters)
    {
    	$cookies = Yii::$app->response->cookies;
    	$cookies->add(new \yii\web\Cookie([
			'name' => 'filters',
			'value' => $filters,
		]));
    }
	
}
