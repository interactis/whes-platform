<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\mysa\Story;
use common\models\mysa\Poi;
use common\models\mysa\Trail;
use common\models\Content;
use common\models\Article;
use common\models\ArticleTranslation;
use common\models\Route;
use common\models\RouteTranslation;
use common\models\Supplier;
use common\models\SupplierTranslation;

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
    		// ->andWhere(['type' => 2]) // local offer
    		->andWhere(['!=', 'type', 4]) // not ambassador
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
			
			if (!empty($poi->supplierName))
				$this->_saveSupplier($poi, $content->id);
			
    		exit;
    	}
	}
	
	private function _saveSupplier($poi, $contentId)
	{
		$model = new Supplier();
		$model->content_id = $contentId;
		$model->street = $poi->supplierStreet;
		$model->street_number = $poi->supplierStreetNumber;
		$model->zip = $poi->supplierZip;
		$model->city = $poi->supplierCity;
		$model->url = $poi->supplierUrl;
		$model->email = $poi->supplierEmail;
		$model->phone = $poi->supplierTel;
		$model->save(false);
		
		foreach ($poi->poiContents as $poiTranslation)
		{
			$translation = new SupplierTranslation();
			$translation->supplier_id = $model->id;
			$translation->language_id = $poiTranslation->languageId;
			$translation->name = $poiTranslation->supplierName;
			$translation->name_affix = $poiTranslation->supplierNameAffix;
			$translation->remarks = $poiTranslation->supplierRemark;
			$translation->save(false);
		}
	}
	
	public function actionTrails()
    {
    	$trails = Trail::find()
    		->where(['status' => 3])
    		->all();
    	
    	foreach($trails as $trail)
    	{
    		$content = $this->_newContentModel(Content::TYPE_ROUTE);
    		$content->save(false);
			
			$model = new Route();
			$model->content_id = $content->id;
			$model->external_id = $trail->permaId;
			$model->geom = $trail->geom;
			$model->difficulty = $trail->difficulty;
			$model->distance_in_km = $trail->distanceInKm;
			$model->duration_in_min = $trail->durationInMin;
			$model->min_altitude = $trail->minAltitude;
			$model->max_altitude = $trail->maxAltitude;
			$model->start_altitude = $trail->startAltitude;
			$model->end_altitude = $trail->endAltitude;
			$model->ascent = $trail->ascent;
			$model->descent = $trail->descent;
			$model->profile = $trail->profile;
			$model->print_available = $trail->printAvailable;
			$model->arrival_station = $trail->arrivalStation;
			$model->departure_station = $trail->departureStation;
			$model->save(false);
			
			foreach ($trail->trailContents as $trailTranslation)
			{
				$translation = new RouteTranslation();
				$translation->route_id = $model->id;
				$translation->language_id = $trailTranslation->languageId;
				$translation->title = $trailTranslation->title;
				$translation->description = $trailTranslation->description;
				$translation->catering = $trailTranslation->catering;
				$translation->options = $trailTranslation->options;
				$translation->remarks = $trailTranslation->generalRemarks;
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
