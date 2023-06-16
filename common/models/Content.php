<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property int|null $heritage_id
 * @property int|null $supplier_id
 * @property int|null $type
 * @property int|null $priority
 * @property int|null $general
 * @property bool|null $visitor
 * @property bool|null $edu
 * @property bool|null $published
 * @property bool|null $featured
 * @property bool|null $hidden
 * @property bool|null $approved
 * @property bool|null $edited
 * @property bool|null $imported
 * @property bool|null $archive
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Article[] $article
 * @property Heritage $heritage
 * @property Supplier $supplier
 * @property ContentFlag[] $contentFlags
 * @property ContentTag[] $contentTags
 * @property ChildContents[] $childContents
 * @property ParentContents[] $parentContents
 
 * @property ContentValidTime[] $contentValidTimes
 * @property Media[] $media
 * @property Poi[] $poi
 * @property Event[] $event
 * @property Route[] $route
 */
class Content extends \yii\db\ActiveRecord
{
	const TYPE_POI = 1;
    const TYPE_ROUTE = 2;
    const TYPE_ARTICLE = 3;
    const TYPE_EVENT = 4;
    
    const TYPE_IDS = [
    	'poi' => 1,
    	'route' => 2,
    	'article' => 3,
    	'event' => 4
    ];
	
	private $_relatedContentLimit = 6;
	private $_rucksackIds = [];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['heritage_id', 'supplier_id', 'type', 'priority', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['heritage_id', 'supplier_id', 'type', 'priority', 'created_at', 'updated_at'], 'integer'],
    
            [['heritage_id'], 'required', 'enableClientValidation' => false, 'when' => function($model) {
            	if ($model->type == $this::TYPE_ARTICLE) {
            		return false;
            	}
            	elseif ($model->type == $this::TYPE_ROUTE) {
            		return false;
            	}
            	elseif ($model->type == $this::TYPE_EVENT) {
            		return false;
            	}
            	else
            		return true;
            }],
            
            [['visitor', 'edu', 'published', 'general', 'featured', 'hidden', 'approved', 'edited', 'imported', 'archive'], 'boolean'],
            [['heritage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Heritage::className(), 'targetAttribute' => ['heritage_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'heritage_id' => Yii::t('app', 'Heritage'),
            'supplier_id' => Yii::t('app', 'Supplier'),
            'type' => Yii::t('app', 'Type'),
            'priority' => Yii::t('app', 'Priority'),
            'general' => Yii::t('app', 'General'),
            'visitor' => Yii::t('app', 'Visitor'),
            'edu' => Yii::t('app', 'EDU'),
            'published' => Yii::t('app', 'Published'),
            'featured' => Yii::t('app', 'Featured'),
            'hidden' => Yii::t('app', 'Hidden'),
            'approved' => Yii::t('app', 'Approved'),
        	'imported' => Yii::t('app', 'Imported'),
        	'archive' => Yii::t('app', 'Archive'),
            'edited' => Yii::t('app', 'Edited'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['content_id' => 'id']);
    }

    /**
     * Gets query for [[Heritage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeritage()
    {
        return $this->hasOne(Heritage::className(), ['id' => 'heritage_id']);
    }
    
    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * Gets query for [[ContentFlags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentFlags($type = false)
    {
        $flags = ContentFlag::find()
        	->joinWith('flag')
        	->where([
        		'content_id' => $this->id,
        		//'flag.hidden' => false
        	]);
        
        if ($type)
        {
        	$flags->andWhere([
        		$type => true		
        	]);
        }
        
        return $flags->orderBy(['flag.order' => SORT_ASC])->all();    
    }

    /**
     * Gets query for [[ContentTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentTags()
    {
        return $this->hasMany(ContentTag::className(), ['content_id' => 'id']);
    }
    
    /**
     * Gets query for [[ChildContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildContents()
    {
        return $this->hasMany(ChildContent::className(), ['parent_content_id' => 'id']);
    }
    
    public function getActiveChildContents()
    {
    	$contents = [];
        foreach($this->childContents as $childContent)
        {
        	$content = $childContent->content;
        	if ($content->isActive)
        		$contents[] = $content;
        }
        
        return $contents;
    }
    
    /**
     * Gets query for [[ChildContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentContents()
    {
        return $this->hasMany(ChildContent::className(), ['child_content_id' => 'id']);
    }
    
    public function getActiveParentContents($type = false)
    {
    	$contents = [];
        foreach($this->parentContents as $parentContent)
        {
        	$content = $parentContent->parentContent;
        	if ($content->isActive)
        	{
        		if ($type)
        		{
        			if (Content::TYPE_IDS[$type] == $content->type)
        				$contents[] = $content;
        		}
        		else
        			$contents[] = $content;
        	}
        }
        
        return $contents;
    }
    
    public function getIsActive()
    {
    	if ($this->published && $this->approved && !$this->hidden && !$this->archive)
    	{
    		return true;
    	}
    	else
    		return false;
    }

    /**
     * Gets query for [[ContentValidTimes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentValidTimes()
    {
        return $this->hasMany(ContentValidTime::className(), ['content_id' => 'id']);
    }
	
    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['content_id' => 'id'])
        	->orderBy(['order' => SORT_ASC, 'id' => SORT_ASC]);
    }

    /**
     * Gets query for [[Poi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoi()
    {
        return $this->hasOne(Poi::className(), ['content_id' => 'id']);
    }
    
    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['content_id' => 'id']);
    }

    /**
     * Gets query for [[Routes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoute()
    {
        return $this->hasOne(Route::className(), ['content_id' => 'id']);
    }
    
    public function getAudio()
    {
    	return Audio::find()
    		->joinWith('audioTranslations')
    		->where(['content_id' => $this->id, 'hidden' => false])
    		->andFilterWhere(['and',
				['audio_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
				['>', 'LENGTH(audio_translation.filename)', 0]
			])
    		->orderBy(['order' => SORT_ASC, 'audio_translation.title' => SORT_ASC])
    		->all();
    }
    
    public function getDownloads()
    {
    	return Download::find()
    		->joinWith('downloadTranslations')
    		->where(['content_id' => $this->id, 'hidden' => false])
    		->andFilterWhere(['and',
				['download_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
				['>', 'LENGTH(download_translation.title)', 0],
				['>', 'LENGTH(download_translation.filename)', 0]
			])
    		->orderBy(['order' => SORT_ASC, 'download_translation.title' => SORT_ASC])
    		->all();
    }
    
    public function getTypes()
    {
    	return [
    		1 => 'poi',
    		2 => 'route',
			3 => 'article',
			4 => 'event'
		];
    }
    
    public function getTypeText()
    {
    	return $this->getTypes()[$this->type];
    }
    
    public function getTypeContent()
    {
    	$type = $this->typeText;
    	return $this->$type;
    	
    }
    
    public function getPreviewImage()
    {
    	$format = 600;
    	if (isset($this->media[0]))
    	{
    		$media = $this->media[0];
    		return [
    			'url' => $media->getImageUrl($format),
    			'alt' => $media->title
    		];
    	}
    	else
    	{
    		return [
    			'url' => Media::getPlaceholderUrl($format),
    			'alt' => ''
    		];
		}
	}
	
	public function getRelatedContent()
    {
    	$heritageContent = $this->_relatedContentQuery(true, false, 4);
    	
    	$otherContent = [];
    	$count = count($heritageContent);
    	if ($count < $this->_relatedContentLimit)
    	{
    		$left = $this->_relatedContentLimit - $count;
    		$otherContent = $this->_relatedContentQuery(false, $this->heritage_id, $left);
    	}
    	
    	return array_merge($heritageContent, $otherContent);
    }
    
    private function _relatedContentQuery($includeHeritage = true, $excludeHeritage = false, $limit = 'default')
    {
    	if ($limit == 'default')
    		$limit = $this->_relatedContentLimit;
    	
    	$query = ContentTag::find()
    		->joinWith('content')
			->select([
        		'content_tag.content_id',
        		'COUNT(content_tag.id) AS tag_count' // required for orderBy below
    		])
    		->where(['in', 'content_tag.tag_id', $this->tagIds])
    		->andWhere(['!=', 'content_tag.content_id', $this->id])
    		->andWhere([
    			'published' => true,
    			'approved' => true,
    			'hidden' => false,
    			Yii::$app->params['frontendType'] => true
    		]);
    	
    	$query->leftJoin('article', 'article.content_id = content.id')
			->leftJoin('poi', 'poi.content_id = content.id')
			->leftJoin('route', 'route.content_id = content.id')
			->leftJoin('event', 'event.content_id = content.id')
			->leftJoin('article_translation', 'article_translation.article_id = article.id')
			->leftJoin('poi_translation', 'poi_translation.poi_id = poi.id')
			->leftJoin('route_translation', 'route_translation.route_id = route.id')
			->leftJoin('event_translation', 'event_translation.event_id = event.id');
    	
    	$query->andFilterWhere(['or',
			['and',
				['article_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
				['>', 'LENGTH(article_translation.title)', 0]
			],
			['and',
				['poi_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
				['>', 'LENGTH(poi_translation.title)', 0]
			],
			['and',
				['route_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
				['>', 'LENGTH(route_translation.title)', 0]
			],
			['and',
				['event_translation.language_id' => \Yii::$app->params['preferredLanguageId']],
				['>', 'LENGTH(event_translation.title)', 0]
			]
		]);
    	
    	if ($includeHeritage)
    		$query = $query->andWhere(['heritage_id' => $this->heritage_id]);
    	
    	if ($excludeHeritage)
    		$query = $query->andWhere(['!=', 'heritage_id', $this->heritage_id]);
    		
    	$query = $query->groupBy('content_tag.content_id')
    		->orderBy(['tag_count' => SORT_DESC])
    		->limit($limit)
    		->all();
    	
    	return $query;
    }
    
    public function setQualityControl($new = true, $approved = false, $save = false)
    {
    	$user = Yii::$app->user->identity;
		if (!$user->isAdmin())
		{
			if (!$new && $approved)
				$this->edited = true;
			
			$this->approved = $approved;
			
			if ($save)
				$this->save(false);
		}
    }
    
    public function getTagIds()
    {
    	$tagIds = ArrayHelper::map($this->contentTags, 'tag_id', 'tag_id');
    	return array_values($tagIds);
    }
    
    public function getTagList()
    {
    	$tagList = [];
    	foreach ($this->contentTags as $contentTag)
    	{
    		$tagList[] = $contentTag->tag->title;
    	}
    	
    	return $tagList;
    }
    
    public function getInRucksack()
    {
    	$rucksackIds = Yii::$app->helpers->getRucksackIds();
    	
    	if (in_array($this->id, $rucksackIds))
    	{
    		return true;
    	}
    	else
    		return false;
    }
    
    public static function getContentList($heritageId = false, $exludeIds = false, $typeIds = false, $contentIds = false)
    {
    	$firstList = [];
    	if ($contentIds)
    	{
    		$firstList = Content::_getContentList($heritageId, $exludeIds, $typeIds, $contentIds);
    		
    		if ($exludeIds)
    		{
    			$exludeIds = array_merge($exludeIds, array_values($contentIds));
    		}
    		else
    			$exludeIds = $contentIds;
    	}
    	
    	$list = Content::_getContentList($heritageId, $exludeIds, $typeIds);
        return $firstList + $list;
    }

	private static function _getContentList($heritageId = false, $exludeIds = false, $typeIds = false, $contentIds = false)
    {
    	$query = Content::find();
    	
    	if ($heritageId)
    		$query->where(['heritage_id' => $heritageId]);
    	
    	if ($exludeIds)
    		$query->andWhere(['not in', 'id', $exludeIds]);
    	
    	if ($typeIds)
    		$query->andWhere(['in', 'type', $typeIds]);
    	
    	if ($contentIds)
    		$query->andWhere(['in', 'id', $contentIds]);
   
    	$models = $query->all();
    	
    	$list = [];
    	foreach ($models as $model)
    	{
    		$type = $model->typeText;
    		if (isset($model->$type))
    		{
    			$list[$model->id] = $model->$type->title .' ('. $type .')';
    		};
    	}
    	
    	if ($contentIds)
    		$list = Content::_sortArrayByArray($list, $contentIds);
    	
        return $list;
    }
    
    private static function _sortArrayByArray(array $array, array $orderArray)
    {
		$ordered = [];
		foreach ($orderArray as $key)
		{
			if (array_key_exists($key, $array))
			{
				$ordered[$key] = $array[$key];
				//unset($array[$key]);
			}
		}
		return $ordered;
	}

}
