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
    	$filters = $this->getFilterCookie();
    	
    	return $this->render('view', [
    		'model' => $model,
    		'content' => $this->findFilterContent($filters, $model->id, false),
    		'filters' => explode(',', $filters),
    		'heritageFilters' => $this->_getHeritageFilters($model)
    	]);
    }
    
    private function _getHeritageFilters($heritage)
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
