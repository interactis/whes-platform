<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "poi_translation".
 *
 * @property int $id
 * @property int|null $poi_id
 * @property int|null $language_id
 * @property string|null $slug
 * @property string|null $title
 * @property string|null $description
 * @property string|null $youtube_id
 * @property string|null $vimeo_id
 * @property string|null $directions
 * @property string|null $remarks
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Language $language
 * @property Poi $poi
 */
class PoiTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poi_translation';
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
            [['poi_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['poi_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'directions', 'remarks'], 'string'],
            [['slug', 'title', 'youtube_id', 'vimeo_id'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['poi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Poi::className(), 'targetAttribute' => ['poi_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'poi_id' => Yii::t('app', 'Poi ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'youtube_id' => Yii::t('app', 'YouTube ID'),
            'vimeo_id' => Yii::t('app', 'Vimeo ID'),
            'directions' => Yii::t('app', 'Direction Instructions (optional)'),
            'remarks' => Yii::t('app', 'Remarks'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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

    /**
     * Gets query for [[Poi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoi()
    {
        return $this->hasOne(Poi::className(), ['id' => 'poi_id']);
    }
}
