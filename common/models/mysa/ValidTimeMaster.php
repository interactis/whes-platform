<?php

namespace common\models\mysa;

use Yii;

/**
 * This is the model class for table "ValidTimeMaster".
 *
 * @property integer $id
 * @property integer $validTimeId
 * @property integer $poiId
 * @property integer $storyId
 * @property integer $trailId
 *
 * @property Poi $poi
 * @property Story $story
 * @property Trail $trail
 * @property ValidTime $validTime
 */
class ValidTimeMaster extends \yii\db\ActiveRecord
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
        return 'ValidTimeMaster';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['validTimeId', 'poiId', 'storyId', 'trailId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'validTimeId' => Yii::t('app', 'Valid Time ID'),
            'poiId' => Yii::t('app', 'Poi ID'),
            'storyId' => Yii::t('app', 'Story ID'),
            'trailId' => Yii::t('app', 'Trail ID'),
        ];
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
    public function getValidTime()
    {
        return $this->hasOne(ValidTime::className(), ['id' => 'validTimeId']);
    }
}
