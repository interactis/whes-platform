<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "route".
 *
 * @property int $id
 * @property int|null $content_id
 * @property int|null $difficulty
 * @property int|null $distance_in_km
 * @property int|null $duration_in_min
 * @property int|null $min_altitude
 * @property int|null $max_altitude
 * @property int|null $start_altitude
 * @property int|null $end_altitude
 * @property int|null $ascent
 * @property int|null $descent
 * @property string|null $profile
 * @property string|null $arrival_station
 * @property string|null $arrival_url
 * @property string|null $departure_station
 * @property string|null $departure_url
 * @property string|null $geom
 * @property bool|null $print_available
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $content
 * @property RouteTranslation[] $routeTranslations
 */
class Route extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'difficulty', 'distance_in_km', 'duration_in_min', 'min_altitude', 'max_altitude', 'start_altitude', 'end_altitude', 'ascent', 'descent', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'difficulty', 'distance_in_km', 'duration_in_min', 'min_altitude', 'max_altitude', 'start_altitude', 'end_altitude', 'ascent', 'descent', 'created_at', 'updated_at'], 'integer'],
            [['profile', 'geom'], 'string'],
            [['print_available'], 'boolean'],
            [['arrival_station', 'arrival_url', 'departure_station', 'departure_url'], 'string', 'max' => 255],
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
            'difficulty' => Yii::t('app', 'Difficulty'),
            'distance_in_km' => Yii::t('app', 'Distance In Km'),
            'duration_in_min' => Yii::t('app', 'Duration In Min'),
            'min_altitude' => Yii::t('app', 'Min Altitude'),
            'max_altitude' => Yii::t('app', 'Max Altitude'),
            'start_altitude' => Yii::t('app', 'Start Altitude'),
            'end_altitude' => Yii::t('app', 'End Altitude'),
            'ascent' => Yii::t('app', 'Ascent'),
            'descent' => Yii::t('app', 'Descent'),
            'profile' => Yii::t('app', 'Profile'),
            'arrival_station' => Yii::t('app', 'Arrival Station'),
            'arrival_url' => Yii::t('app', 'Arrival Url'),
            'departure_station' => Yii::t('app', 'Departure Station'),
            'departure_url' => Yii::t('app', 'Departure Url'),
            'geom' => Yii::t('app', 'Geom'),
            'print_available' => Yii::t('app', 'Print Available'),
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
     * Gets query for [[RouteTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRouteTranslations()
    {
        return $this->hasMany(RouteTranslation::className(), ['route_id' => 'id']);
    }
}
