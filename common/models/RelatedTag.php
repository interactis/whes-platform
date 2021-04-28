<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "related_tag".
 *
 * @property int $id
 * @property int|null $tag_id
 * @property int|null $related_tag_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Tag $tag
 * @property Tag $relatedTag
 */
class RelatedTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'related_tag';
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
            [['tag_id', 'related_tag_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['tag_id', 'related_tag_id', 'created_at', 'updated_at'], 'integer'],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
            [['related_tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['related_tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
            'related_tag_id' => Yii::t('app', 'Related Tag ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * Gets query for [[RelatedTag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'related_tag_id']);
    }
}
