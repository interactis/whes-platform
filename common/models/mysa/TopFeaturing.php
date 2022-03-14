<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "TopFeaturing".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $poiId
 * @property integer $tagId
 * @property integer $storyId
 *
 * @property Poi $poi
 * @property Story $story
 * @property Tag $tag
 * @property TopFeaturingType $type0
 */
class TopFeaturing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TopFeaturing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'poiId', 'tagId', 'storyId'], 'integer'],
            [['poiId'], 'exist', 'skipOnError' => true, 'targetClass' => Poi::className(), 'targetAttribute' => ['poiId' => 'id']],
            [['storyId'], 'exist', 'skipOnError' => true, 'targetClass' => Story::className(), 'targetAttribute' => ['storyId' => 'id']],
            [['tagId'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tagId' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => TopFeaturingType::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'poiId' => Yii::t('app', 'Poi ID'),
            'tagId' => Yii::t('app', 'Tag ID'),
            'storyId' => Yii::t('app', 'Story ID'),
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
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tagId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(TopFeaturingType::className(), ['id' => 'type']);
    }
}
