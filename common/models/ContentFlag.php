<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "content_flag".
 *
 * @property int $id
 * @property int|null $content_id
 * @property int|null $flag_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $content
 * @property Flag $flag
 */
class ContentFlag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_flag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'flag_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'flag_id', 'created_at', 'updated_at'], 'integer'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['flag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flag::className(), 'targetAttribute' => ['flag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'flag_id' => Yii::t('app', 'Flag ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Content]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * Gets query for [[Flag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlag()
    {
        return $this->hasOne(Flag::className(), ['id' => 'flag_id']);
    }
}
