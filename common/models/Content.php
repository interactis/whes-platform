<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property int|null $heritage_id
 * @property int|null $type
 * @property int|null $priority
 * @property bool|null $published
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
            [['heritage_id'], 'required'],
            [['published', 'hidden'], 'boolean'],
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
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['content_id' => 'id']);
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
    public function getPois()
    {
        return $this->hasMany(Poi::className(), ['content_id' => 'id']);
    }

    /**
     * Gets query for [[Routes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes()
    {
        return $this->hasMany(Route::className(), ['content_id' => 'id']);
    }

    /**
     * Gets query for [[Suppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuppliers()
    {
        return $this->hasMany(Supplier::className(), ['content_id' => 'id']);
    }
}
