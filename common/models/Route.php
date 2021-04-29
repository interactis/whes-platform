<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;

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
class Route extends HelperModel
{
	public $translationFields = ['title','description', 'youtube_id', 'catering', 'options', 'remarks'];
	public $requiredTranslationFields = ['title', 'description'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route';
    }
    
    public static function pluralName()
    {
    	return Yii::t('app', 'Routes');
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
            [['content_id', 'difficulty', 'distance_in_km', 'duration_in_min', 'min_altitude', 'max_altitude', 'start_altitude', 'end_altitude', 'ascent', 'descent', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'difficulty', 'distance_in_km', 'duration_in_min', 'min_altitude', 'max_altitude', 'start_altitude', 'end_altitude', 'ascent', 'descent', 'created_at', 'updated_at'], 'integer'],
            [['profile', 'geom'], 'string'],
            [['print_available'], 'boolean'],
            [['arrival_station', 'arrival_url', 'departure_station', 'departure_url'], 'string', 'max' => 255],
            [['arrival_url', 'departure_url'], 'url'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['tags'], 'required'],
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
            'distance_in_km' => Yii::t('app', 'Distance in Km'),
            'duration_in_min' => Yii::t('app', 'Duration in Minutes'),
            'min_altitude' => Yii::t('app', 'Min Altitude (Metres above Sea Level)'),
            'max_altitude' => Yii::t('app', 'Max Altitude (Metres above Sea Level)'),
            'start_altitude' => Yii::t('app', 'Start Altitude (Metres above Sea Level)'),
            'end_altitude' => Yii::t('app', 'End Altitude (Metres above Sea Level)'),
            'ascent' => Yii::t('app', 'Ascent in Meters'),
            'descent' => Yii::t('app', 'Descent in Meters'),
            'profile' => Yii::t('app', 'Profile'),
            'arrival_station' => Yii::t('app', 'Arrival Station Name'),
            'arrival_url' => Yii::t('app', 'Arrival Station URL'),
            'departure_station' => Yii::t('app', 'Departure Station Name'),
            'departure_url' => Yii::t('app', 'Departure Station URL'),
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
