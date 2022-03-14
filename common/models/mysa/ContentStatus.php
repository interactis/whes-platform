<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ContentStatus".
 *
 * @property integer $id
 * @property string $statusName
 *
 * @property Poi[] $pois
 * @property Story[] $stories
 * @property Tag[] $tags
 * @property Trail[] $trails
 */
class ContentStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ContentStatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statusName'], 'required'],
            [['statusName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'statusName' => Yii::t('app', 'Status Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPois()
    {
        return $this->hasMany(Poi::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStories()
    {
        return $this->hasMany(Story::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrails()
    {
        return $this->hasMany(Trail::className(), ['status' => 'id']);
    }
}
