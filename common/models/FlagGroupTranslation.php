<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flag_group_translation".
 *
 * @property int $id
 * @property int|null $flag_group_id
 * @property int|null $language_id
 * @property string|null $title
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property FlagGroup $flagGroup
 * @property Language $language
 */
class FlagGroupTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flag_group_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_group_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['flag_group_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string'],
            [['flag_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlagGroup::className(), 'targetAttribute' => ['flag_group_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'flag_group_id' => Yii::t('app', 'Flag Group ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[FlagGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlagGroup()
    {
        return $this->hasOne(FlagGroup::className(), ['id' => 'flag_group_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
