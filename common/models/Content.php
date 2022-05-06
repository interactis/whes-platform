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
 * @property int|null $type
 * @property int|null $priority
 * @property int|null $general
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
 * @property Article[] $articles
 * @property Heritage $heritage
 * @property ContentFlag[] $contentFlags
 * @property ContentTag[] $contentTags
 * @property ContentValidTime[] $contentValidTimes
 * @property Media[] $media
 * @property Poi[] $pois
 * @property Route[] $routes
 * @property Supplier[] $suppliers
 */
class Content extends \yii\db\ActiveRecord
{
	const TYPE_POI = 1;
    const TYPE_ROUTE = 2;
    const TYPE_ARTICLE = 3;
	
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
            [['heritage_id', 'type', 'priority', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['heritage_id', 'type', 'priority', 'created_at', 'updated_at'], 'integer'],
    
            [['heritage_id'], 'required', 'enableClientValidation' => false, 'when' => function($model) {
            	if ($model->type == $this::TYPE_ARTICLE) {
            		return false;
            	}
            	elseif ($model->type == $this::TYPE_ROUTE) {
            		return false;
            	}
            	else
            		return true;
            }],
            
            [['published', 'general', 'featured', 'hidden', 'approved', 'edited', 'imported', 'archive'], 'boolean'],
            [['heritage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Heritage::className(), 'targetAttribute' => ['heritage_id' => 'id']],
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
            'type' => Yii::t('app', 'Type'),
            'priority' => Yii::t('app', 'Priority'),
            'general' => Yii::t('app', 'General'),
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
     * Gets query for [[Articles]].
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
     * Gets query for [[ContentFlags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentFlags()
    {
        return ContentFlag::find()
        	->joinWith('flag')
        	->where([
        		'content_id' => $this->id,
        		'flag.hidden' => false
        	])
        	->orderBy(['flag.order' => SORT_ASC])
        	->all();    
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
     * Gets query for [[Pois]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoi()
    {
        return $this->hasOne(Poi::className(), ['content_id' => 'id']);
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

    /**
     * Gets query for [[Suppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['content_id' => 'id']);
    }
    
    public function getTypes()
    {
    	return [
    		1 => 'poi',
    		2 => 'route',
			3 => 'article'
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
    
    public static function getContentList($heritageId = false)
    {
    	$query = Content::find();
    	
    	if ($heritageId)
    		$query->where(['heritage_id' => $heritageId]);
   
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
        return $list;
    }
}
