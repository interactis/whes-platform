<?php

namespace common\models\mysa;

use Yii;

/**
 * This is the model class for table "TagMaster".
 *
 * @property integer $id
 * @property integer $storyId
 * @property integer $tagId
 * @property integer $tagId2
 * @property integer $trailId
 * @property integer $poiId
 * @property integer $mediaId
 *
 * @property Poi $poi
 * @property Story $story
 * @property Story $story0
 * @property Tag $tag
 * @property Tag $tag2
 * @property Trail $trail
 * @property Media $media
 */
class TagMaster extends \yii\db\ActiveRecord
{
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TagMaster';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['storyId', 'tagId', 'tagId2', 'trailId', 'poiId', 'mediaId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'storyId' => Yii::t('app', 'Story ID'),
            'tagId' => Yii::t('app', 'Tag ID'),
            'tagId2' => Yii::t('app', 'Tag Id2'),
            'trailId' => Yii::t('app', 'Trail ID'),
            'poiId' => Yii::t('app', 'POI ID'),
            'mediaId' => Yii::t('app', 'Media ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoi()
    {
        return $this->hasOne(ConvertedPoi::className(), ['id' => 'poiId']);
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
    public function getStory0()
    {
        return $this->hasOne(Story::className(), ['id' => 'storyId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tagId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag2()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tagId2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrail()
    {
        return $this->hasOne(ConvertedTrail::className(), ['id' => 'trailId']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(ConvertedTrail::className(), ['id' => 'mediaId']);
    }

    /**
     * @return array tagContent for tag1 and tag2.
     */
    public function getTagContent()
    {
        $tagContents = [];
        if ($this->tag) $tagContents[] = $this->tag;
        if ($this->tag2) $tagContents[] = $this->tag2;
        return $tagContents;
    }
}