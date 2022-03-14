<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\mysa\Story;
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
			
			$article = new Article();
			$article->content_id = $content->id;
			$article->save(false);
			
			foreach ($story->storyContents as $storyTranslation)
			{
				$translation = new ArticleTranslation();
				$translation->article_id = $article->id;
				$translation->language_id = $storyTranslation->languageId;
				$translation->title = $storyTranslation->title;
				$translation->excerpt = $storyTranslation->excerpt;
				$translation->description = $storyTranslation->story;
				$translation->save(false);
			}
			
			$article->generateSlugs();
    		exit;
    	}
	}
	
	private function _newContentModel($type)
	{
		$model = new Content();
    	$model->type = Content::TYPE_ARTICLE;
    	$model->priority = 3;
    	$model->heritage_id = Yii::$app->params['sajaHeritageId'];
    	$model->imported = true;
    	return $model;
	}
	
	
}
