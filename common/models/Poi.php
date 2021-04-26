<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "poi".
 *
 * @property int $id
 * @property int|null $content_id
 * @property string|null $arrival_station
 * @property string|null $arrival_url
 * @property string|null $geom
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AmbassadorTranslation[] $ambassadorTranslations
 * @property Content $content
 * @property PoiTranslation[] $poiTranslations
 */
class Poi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poi';
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
            [['content_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'created_at', 'updated_at'], 'integer'],
            [['geom'], 'string'],
            [['arrival_station', 'arrival_url'], 'string', 'max' => 255],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
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
            'arrival_station' => Yii::t('app', 'Arrival Station'),
            'arrival_url' => Yii::t('app', 'Arrival Url'),
            'geom' => Yii::t('app', 'Geom'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[AmbassadorTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAmbassadorTranslations()
    {
        return $this->hasMany(AmbassadorTranslation::className(), ['poi_id' => 'id']);
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
     * Gets query for [[PoiTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoiTranslations()
    {
        return $this->hasMany(PoiTranslation::className(), ['poi_id' => 'id']);
    }
}
