<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;
use common\components\SwissGeometryBehavior;

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
	public $translationFields = ['title','description', 'youtube_id', 'catering', 'options', 'directions', 'remarks'];
	public $requiredTranslationFields = ['title', 'description'];
	
	public $geomUpload;
	
	const DIFFICULTY_EASY = 1;
    const DIFFICULTY_MEDIUM = 2;
    const DIFFICULTY_DIFFICULT = 3;
	
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
            [
                'class' => SwissGeometryBehavior::className(),
                'type' => SwissGeometryBehavior::GEOMETRY_LINESTRING,
                'attribute' => 'geom',
            ],
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
            [['tags', 'flags'], 'required'],
            ['difficulty', 'in', 'range' => [self::DIFFICULTY_EASY, self::DIFFICULTY_MEDIUM, self::DIFFICULTY_DIFFICULT]],
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
            'min_altitude' => Yii::t('app', 'Lowest Point (Metres above Sea Level)'),
            'max_altitude' => Yii::t('app', 'Highest Point (Metres above Sea Level)'),
            'start_altitude' => Yii::t('app', 'Start Altitude (Metres above Sea Level)'),
            'end_altitude' => Yii::t('app', 'End Altitude (Metres above Sea Level)'),
            'ascent' => Yii::t('app', 'Ascent in Meters'),
            'descent' => Yii::t('app', 'Descent in Meters'),
            'profile' => Yii::t('app', 'Profile'),
            'arrival_station' => Yii::t('app', 'SBB Arrival Station Name'),
            'arrival_url' => Yii::t('app', 'Arrival Station URL'),
            'departure_station' => Yii::t('app', 'SBB Departure Station Name'),
            'departure_url' => Yii::t('app', 'Departure Station URL'),
            'geom' => Yii::t('app', 'Geom'),
            'print_available' => Yii::t('app', 'Print Available'),
            'flags' =>  Yii::t('app', 'Filters'),
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
    
    public function getLabel()
    {
    	return $this->getFlagLabel(Yii::t('app', 'Route')) .'<br />
    		<em>'. $this->content->heritage->short_name .'</em>';
    }
    
    public function getDifficulties($uppercase = false)
    {
    	if ($uppercase)
    	{
			return [
				1 => Yii::t('app', 'Easy'),
				2 => Yii::t('app', 'Medium'),
				3 => Yii::t('app', 'Difficult')
			];
		}
		else
		{
			return [
				1 => Yii::t('app', 'easy'),
				2 => Yii::t('app', 'medium'),
				3 => Yii::t('app', 'difficult')
			];
		}
    }
    
    public function getDifficultyText()
    {
    	return $this->difficulties[$this->difficulty];
    }
    
    public function getDurationText()
	{
		$hours = floor($this->duration_in_min / 60);
   	 	$minutes = ($this->duration_in_min % 60);
		
		$hoursText = '';
		if ($hours > 0)
		{
			$hoursText = $hours ." ". Yii::t('app', 'hour') .' ';
			if ($hours > 1)
				$hoursText = $hours ." ". Yii::t('app', 'hours') .' ';
		}
		
		$minutesText = '';
		if ($minutes > 0)
			$minutesText = $minutes ." ". Yii::t('app', 'min.');
				
		return $hoursText . $minutesText;
	}
	
	public function getDistanceText()
	{
		return number_format($this->distance_in_km, 0, ',', "'") .' km';
	}
	
	public function getAltituteText($field)
	{
		return number_format($this->{$field}, 0, ',', "'") . ' '. Yii::t('app', 'm a.s.l.');
	}
	
	public function getMetersText($field)
	{
		return number_format($this->{$field}, 0, ',', "'") .' m';
	}
}
