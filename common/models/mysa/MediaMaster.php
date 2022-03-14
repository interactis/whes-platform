<?php

namespace common\models\mysa;

use Yii;

/**
 * This is the model class for table "MediaMaster".
 *
 * @property integer $id
 * @property integer $poiId
 * @property integer $storyId
 * @property integer $position
 * @property integer $trailId
 * @property integer $tagId
 * @property integer $mediaId
 *
 * @property MediaDescription[] $mediaDescriptions
 * @property MediaType $type0
 * @property Poi $poi
 * @property Story $story
 * @property Trail $trail
 * @property Tag $tag
 */
class MediaMaster extends \yii\db\ActiveRecord
{
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}
	
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MediaMaster';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mediaId'], 'required'],
            [['poiId', 'storyId', 'position', 'trailId', 'tagId', 'mediaId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'poiId' => Yii::t('app', 'Poi ID'),
            'storyId' => Yii::t('app', 'Story ID'),
            'position' => Yii::t('app', 'Position'),
            'trailId' => Yii::t('app', 'Trail ID'),
            'tagId' => Yii::t('app', 'Tag ID'),
            'mediaId' => Yii::t('app', 'Media ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaDescriptions()
    {
        return $this->hasMany(MediaDescription::className(), ['mediaMasterId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(MediaType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoi()
    {
        return $this->hasOne(Poi::className(), ['id' => 'poiId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStory()
    {
        return $this->hasOne(Story::className(), ['id' => 'storyId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrail()
    {
        return $this->hasOne(Trail::className(), ['id' => 'trailId']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tagId']);
    }
    
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'mediaId']);
    }
}
