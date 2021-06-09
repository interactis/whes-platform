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
 * @property bool|null $published
 * @property bool|null $featured
 * @property bool|null $hidden
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Article[] $articles
 * @property Heritage $heritage
 * @property ContentFlag[] $contentFlags
 * @property ContentTag[] $contentTags
 * @property ContentValidTime[] $contentValidTimes
 * @property Exhibit[] $exhibits
 * @property ExhibitRucksack[] $exhibitRucksacks
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
	
	private $_relatedContentLimit = 9;
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
            	else
            		return true;
            }],
            
            [['published', 'featured', 'hidden'], 'boolean'],
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
            'published' => Yii::t('app', 'Published'),
            'featured' => Yii::t('app', 'Featured'),
            'hidden' => Yii::t('app', 'Hidden'),
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
        return $this->hasMany(ContentFlag::className(), ['content_id' => 'id']);
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
     * Gets query for [[Exhibits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExhibits()
    {
        return $this->hasMany(Exhibit::className(), ['content_id' => 'id']);
    }

    /**
     * Gets query for [[ExhibitRucksacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitRucksacks()
    {
        return $this->hasMany(ExhibitRucksack::className(), ['content_id' => 'id']);
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
    	$heritageContent = $this->_relatedContentQuery();
    	
    	$otherContent = [];
    	if ($count = count($heritageContent) < $this->_relatedContentLimit)
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
    		->andWhere(['published' => true, 'hidden' => false]);
    	
    	if ($includeHeritage)
    		$query = $query->andWhere(['heritage_id' => $this->heritage_id]);
    	
    	if ($excludeHeritage)
    		$query = $query->andWhere(['!=', 'heritage_id', $this->heritage_id]);
    		
    	$query = $query->groupBy('content_tag.content_id')
    		->orderBy(['tag_count' => SORT_DESC])
    		->limit(9)
    		->all();
    	
    	
    	return $query;
    }
    
    public function getTagIds()
    {
    	$tagIds = ArrayHelper::map($this->contentTags, 'tag_id', 'tag_id');
    	return array_values($tagIds);
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
}
