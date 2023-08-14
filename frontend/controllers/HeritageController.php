<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
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
    	
    	$filters = implode(',', $heritageFiltersSet);
    	$totalContent = $this->totalContent($filters, $model->id, false);
    	
    	return $this->render('view', [
    		'model' => $model,
    		'content' => $this->findFilterContent($filters, $model->id, false),
    		'filters' => $heritageFiltersSet,
    		'heritageFilters' => $heritageFilters,
    		'totalContent' => $totalContent,
    		'showMoreBtn' => $this->showMoreBtn($totalContent)
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
