<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "flag_translation".
 *
 * @property int $id
 * @property int|null $flag_id
 * @property int|null $language_id
 * @property string|null $title
 * @property string|null $disclaimer
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Flag $flag
 * @property Language $language
 */
class FlagTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flag_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['flag_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'disclaimer'], 'string'],
            [['flag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flag::className(), 'targetAttribute' => ['flag_id' => 'id']],
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
            'flag_id' => Yii::t('app', 'Flag ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'title' => Yii::t('app', 'Title'),
            'disclaimer' => Yii::t('app', 'Disclaimer'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
