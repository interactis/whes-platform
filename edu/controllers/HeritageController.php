<?php
namespace edu\controllers;

use Yii;
use edu\components\HelperController;
use common\models\Heritage;
use common\models\Content;
use yii\web\NotFoundHttpException;

/**
 * Heritage controller
 */
 
class HeritageController extends HelperController
{
    public function actionView($slug)
    {
    	$model = $this->findModel($slug);
    	$globalFiltersSet = $this->getFilterCookie(true);
    	$heritageFilters = $this->getHeritageFilters($model);
    	$heritageFiltersSet = $this->_getHeritageFiltersSet($globalFiltersSet, $heritageFilters);
    	
    	return $this->render('view', [
    		'model' => $model,
    		'content' => $this->findFilterContent(implode(',', $heritageFiltersSet), $model->id, false),
    		'filters' => $heritageFiltersSet,
    		'heritageFilters' => $heritageFilters
    	]);
    }
    
    private function _getHeritageFiltersSet($globalFiltersSet, $heritageFilters)
    {
    	$filtersSet = [];
    	if ($globalFiltersSet)
    	{
    		foreach ($globalFiltersSet as $globalFilterSet)
			{
				if (in_array($globalFilterSet, $heritageFilters))
					$filtersSet[] = $globalFilterSet;
			}
    	}
    	return $filtersSet;
    }
    
 	protected function findModel($slug)
    {
        $model = Heritage::find()
        	->joinWith('heritageTranslations')
			->where([
				'slug' => $slug,
				'published' => true
			])->one();
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }
}
