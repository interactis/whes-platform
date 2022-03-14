<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\mysa\Story;
use common\models\mysa\Poi;
use common\models\mysa\PoiTranslation;
use common\models\Content;
use common\models\Article;
use common\models\ArticleTranslation;

/**
 * Migration controller
 */
class MigrationController extends Controller
{
		
	public function actionStories()
    {
    	$stories = Story::find()->where(['status' => 3])->all();
    	
    	foreach($stories as $story)
    	{
    		$content = $this->_newContentModel(Content::TYPE_ARTICLE);
    		$content->save(false);
			
			$model = new Article();
			$model->content_id = $content->id;
			$model->external_id = $story->permaId;
			$model->save(false);
			
			foreach ($story->storyContents as $storyTranslation)
			{
				$translation = new ArticleTranslation();
				$translation->article_id = $model->id;
				$translation->language_id = $storyTranslation->languageId;
				$translation->title = $storyTranslation->title;
				$translation->excerpt = $storyTranslation->excerpt;
				$translation->description = $storyTranslation->story;
				$translation->save(false);
			}
			$model->generateSlugs();
    		exit;
    	}
	}
	
	public function actionPois()
    {
    	$pois = Poi::find()
    		->where(['status' => 3])
    		->andWhere(['!=', 'type', 4])
    		->all();
    	
    	foreach($pois as $poi)
    	{
    		$content = $this->_newContentModel(Content::TYPE_POI);
    		$content->save(false);
			
			$model = new \common\models\Poi();
			$model->content_id = $content->id;
			$model->external_id = $poi->permaId;
			$model->geom = $poi->geom;
			$model->arrival_station = $poi->arrivalStation;
			$model->save(false);
			
			foreach ($poi->poiContents as $poiTranslation)
			{
				$translation = new \common\models\PoiTranslation();
				$translation->poi_id = $model->id;
				$translation->language_id = $poiTranslation->languageId;
				$translation->title = $poiTranslation->title;
				$translation->description = $poiTranslation->description;
				$translation->directions = $poiTranslation->directions;
				$translation->save(false);
			}
			$model->generateSlugs();
    		exit;
    	}
	}
	
	private function _newContentModel($type)
	{
		$model = new Content();
    	$model->type = $type;
    	$model->priority = 3;
    	$model->heritage_id = Yii::$app->params['sajaHeritageId'];
    	$model->imported = true;
    	return $model;
	}
}
