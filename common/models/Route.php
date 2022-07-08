<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;
use common\components\SwissGeometryBehavior;
use yii\web\UploadedFile;


/**
 * This is the model class for table "route".
 *
 * @property int $id
 * @property int $external_id
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
	public $translationFields = ['title', 'slug', 'description', 'youtube_id', 'vimeo_id', 'catering', 'options', 'directions', 'remarks'];
	public $requiredTranslationFields = ['title', 'description'];
	
	public $geojsonFile;
	public $removeGeom = false;
	
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
            [['content_id', 'external_id', 'difficulty', 'distance_in_km', 'duration_in_min', 'min_altitude', 'max_altitude', 'start_altitude', 'end_altitude', 'ascent', 'descent', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'external_id', 'difficulty', 'distance_in_km', 'duration_in_min', 'min_altitude', 'max_altitude', 'start_altitude', 'end_altitude', 'ascent', 'descent', 'created_at', 'updated_at'], 'integer'],
            [['profile'], 'string'],
            [['print_available', 'removeGeom'], 'boolean'],
            [['arrival_station', 'arrival_url', 'departure_station', 'departure_url'], 'string', 'max' => 255],
            [['arrival_url', 'departure_url'], 'url'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['tags', 'flags'], 'required'],
            [['childContentIds'], 'safe'],
            ['difficulty', 'in', 'range' => [self::DIFFICULTY_EASY, self::DIFFICULTY_MEDIUM, self::DIFFICULTY_DIFFICULT]],
            
            ['geojsonFile', 'file', 'extensions' => ['geojson']],
            ['geom', 'handleFileUpload', 'skipOnEmpty' => false, 'skipOnError' => false]
        ];
    }
	
	public function handleFileUpload($attribute, $params)
    {
    	if ($file = UploadedFile::getInstance($this, 'geojsonFile'))
		{
			$string = file_get_contents($file->tempName);
			$json = json_decode($string, true);
			
			if (!isset($json['crs']['properties']['name']) OR $json['crs']['properties']['name'] != 'urn:ogc:def:crs:EPSG::21781')
			{
				$this->addError($attribute, 'Wrong data projection. Please use Swiss projection EPSG:21781.');
			}
			else
			{
				if (!isset($json['features'][0]['geometry']) OR $json['features'][0]['geometry']['type'] != 'LineString')
				{
					$this->addError($attribute, 'Please use geometry type LineString.');
				}
				else
				{
					$coordinates = $json['features'][0]['geometry']['coordinates'];
					$this->geom = $coordinates;
				}
			}	
		}
    }
	
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'external_id' => Yii::t('app', 'External ID'),
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
            'childContentIds' => Yii::t('app', 'Stages (Child Routes)'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'geojsonFile' => Yii::t('app', 'GeoJSON File'),
            'removeGeom' => Yii::t('app', 'Remove Geometry')
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
    	$html = $this->getFlagLabel(Yii::t('app', 'Route'));
    	
    	if (isset($this->content->heritage))
    		$html .= '<br /><em>'. $this->content->heritage->short_name .'</em>';
    		
    	return $html;
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
	
	public function getRoutePois()
    {
    	/*
		if (!empty($this->geom))
		{
			return Poi::find()
    			->joinWith('content')
    			->where('ST_DWithin(geom, \''. $this->geom .'\', '. \Yii::$app->params['routePoiBuffer'] .')')
    			->andWhere(['published' => true, 'hidden' => false])
    			->limit(18)
    			->all();
    	}
    	*/
    	return false;
    }
    
    /**
     * @param $geom
     * Store geoJson to postgis geometry field.
     */
    public function setGeom($coordinates)
    {
    	//$geom = GeoJsonHelper::toGeometry('LineString', $coordinates, '21781');
        $this->geom = $coordinates;
    }
    
    private function _relatedContentQuery($includeHeritage = true, $excludeHeritage = false, $limit = 'default')
    {
    	if ($limit == 'default')
    		$limit = $this->_relatedContentLimit;
    	
    	$query = ContentTag::find()
    		->joinWith('content')
			->select([
        		'content_tag.content_id',
        		'COUNT(content_tag.id) AS tag_count' // required for orderBy below
    		])
    		->where(['in', 'content_tag.tag_id', $this->tagIds])
    		->andWhere(['!=', 'content_tag.content_id', $this->id])
    		->andWhere(['published' => true, 'hidden' => false]);
    	
    	if ($includeHeritage)
    		$query = $query->andWhere(['heritage_id' => $this->heritage_id]);
    	
    	if ($excludeHeritage)
    		$query = $query->andWhere(['!=', 'heritage_id', $this->heritage_id]);
    		
    	$query = $query->groupBy('content_tag.content_id')
    		->orderBy(['tag_count' => SORT_DESC])
    		->limit(9)
    		->all();
    	
    	
    	return $query;
    }
}
