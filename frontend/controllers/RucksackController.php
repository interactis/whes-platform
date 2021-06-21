<?php
namespace frontend\controllers;

use Yii;
use frontend\components\HelperController;
use common\models\Content;
use common\models\ContentTag;
use yii\web\NotFoundHttpException;
use \yii\web\Cookie;
use yii\helpers\ArrayHelper;

class RucksackController extends HelperController
{   

	public function actionIndex()
    {
    	$ids = Yii::$app->helpers->getRucksackIds();
    	$models = $this->findContent(false, false, false, 'default', 0, $ids);
    	
    	return $this->render('index', [
    		'models' => $models,
    		'related' => $this->_getRelatedContent($models)
    	]);	
    }
	
    public function actionToggle($id)
    {
    	$this->layout = false;
    	$model = $this->_findContent($id);
    	$this->_setRucksackCookie($model);    	
    	return true;
    }
    
    private function _setRucksackCookie($model)
    {
    	$id = $model->id;
    	$ids = Yii::$app->helpers->getRucksackIds();
  		
    	if (($key = array_search($id, $ids)) !== false)
    	{
    		//remove from cookie
			unset($ids[$key]);
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
    
    private function _findContent($id)
    {
    	$model = Content::find()->where([
    		'id' => $id,
    		'published' => true
    	])->one();
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }
	
	
	private function _getRelatedContent($models)
    {
    	$tagIds = $this->_getTagIds($models);
    	$excludeIds = array_values(ArrayHelper::map($models, 'id', 'id'));
    	
    	$query = ContentTag::find()
    		->joinWith('content')
			->select([
        		'content_tag.content_id',
        		'COUNT(content_tag.id) AS tag_count' // required for orderBy below
    		])
    		->where(['in', 'content_tag.tag_id', $tagIds])
    		->andWhere(['not in', 'content_tag.content_id', $excludeIds])
    		->andWhere(['published' => true, 'approved' => true, 'hidden' => false]);
    	
    	$query->leftJoin('article', 'article.content_id = content.id')
			->leftJoin('poi', 'poi.content_id = content.id')
			->leftJoin('route', 'route.content_id = content.id')
			->leftJoin('article_translation', 'article_translation.article_id = article.id')
			->leftJoin('poi_translation', 'poi_translation.poi_id = poi.id')
			->leftJoin('route_translation', 'route_translation.route_id = route.id');
    	
    	$query->andFilterWhere(['or',
			['article_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
			['poi_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
			['route_translation.language_id' => \Yii::$app->params['preferredLanguageId']]
		]);
    	
    	return $query->groupBy('content_tag.content_id')
    		->orderBy(['tag_count' => SORT_DESC])
    		->limit(9)
    		->all();
    }
    
    public function _getTagIds($models)
    {
    	$ids = [];
    	foreach($models as $model)
    	{
    		$tagIds = array_values(ArrayHelper::map($model->contentTags, 'tag_id', 'tag_id'));
    		$ids = array_merge($ids, $tagIds);
    	}
    	
    	$tagCounts = array_count_values($ids);
    	arsort($tagCounts);
		return array_slice(array_keys($tagCounts), 0, 12);
    }
}
