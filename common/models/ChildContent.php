<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "child_content".
 *
 * @property int $id
 * @property int|null $parent_content_id
 * @property int|null $child_content_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $parentContent
 * @property Content $childContent
 */
class ChildContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'child_content';
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
            [['parent_content_id', 'child_content_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['parent_content_id', 'child_content_id', 'created_at', 'updated_at'], 'integer'],
            [['parent_content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['parent_content_id' => 'id']],
            [['child_content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['child_content_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_content_id' => Yii::t('app', 'Parent Content ID'),
            'child_content_id' => Yii::t('app', 'Child Content ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ParentContent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'parent_content_id']);
    }

    /**
     * Gets query for [[ChildContent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'child_content_id']);
    }
}
