<?php

namespace common\models\mysa;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "Trail".
 *
 * @property integer $id
 * @property integer $permaId
 * @property integer $distanceInKm
 * @property integer $durationInMin
 * @property integer $minAltitude
 * @property integer $maxAltitude
 * @property integer $startAltitude
 * @property integer $endAltitude
 * @property integer $difficulty
 * @property string $arrivalStation
 * @property integer $arrivalStationType
 * @property string $arrivalSbbCode
 * @property string $departureStation
 * @property integer $departureStationType
 * @property string $departureSbbCode
 * @property integer $status
 * @property string $creationTime
 * @property string $profile
 * @property string $geom
 * @property integer $printAvailable
 *
 * @property MediaMaster[] $mediaMasters
 * @property ContentStatus $status0
 * @property StationType $arrivalStationType0
 * @property StationType $departureStationType0
 * @property TrailDifficulty $difficulty0
 * @property TrailContent[] $trailContents
 * @property ValidTimeMaster[] $validTimeMasters
 */
class Trail extends TranslatedModel
{
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}
	
	public $validTimes = [];
	public $relatedTags = [];
	public $images = [];
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Trail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['distanceInKm', 'durationInMin', 'ascent', 'descent', 'minAltitude', 'maxAltitude', 'startAltitude', 'endAltitude', 'difficulty', 'arrivalStation', 'departureStation', 'arrivalStationType', 'departureStationType', 'arrivalSbbCode', 'departureSbbCode', 'status', 'relatedTags', 'validTimes'], 'required'],
            [['distanceInKm', 'durationInMin', 'ascent', 'descent', 'minAltitude', 'maxAltitude', 'startAltitude', 'endAltitude', 'difficulty', 'arrivalStationType', 'departureStationType', 'status', 'printAvailable'], 'integer'],
            [['arrivalSbbCode', 'departureSbbCode'], 'string'],
            [['recommended'], 'boolean'],
            [['creationTime'], 'safe'],
            [['arrivalStation', 'departureStation'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'permaId' => Yii::t('app', 'Perma ID'),
            'distanceInKm' => Yii::t('app', 'Distance In Km'),
            'durationInMin' => Yii::t('app', 'Duration In Min'),
            'minAltitude' => Yii::t('app', 'Min Altitude'),
            'maxAltitude' => Yii::t('app', 'Max Altitude'),
            'startAltitude' => Yii::t('app', 'Start Altitude'),
            'endAltitude' => Yii::t('app', 'End Altitude'),
            'difficulty' => Yii::t('app', 'Difficulty'),
            'arrivalStation' => Yii::t('app', 'Arrival Station'),
            'arrivalStationType' => Yii::t('app', 'Arrival Station Type'),
            'arrivalSbbCode' => Yii::t('app', 'Arrival SBB Code'),
            'departureStation' => Yii::t('app', 'Departure Station'),
            'departureStationType' => Yii::t('app', 'Departure Station Type'),
            'departureSbbCode' => Yii::t('app', 'Departure SBB Code'),
            'status' => Yii::t('app', 'Status'),
            'creationTime' => Yii::t('app', 'Creation Time'),
            'profile' => Yii::t('app', 'Profile'),
            'geom' => Yii::t('app', 'Geom'),
            'printAvailable' => Yii::t('app', 'Print Available'),
            // attributes for backend grid
            'title' => Yii::t('app', 'Title'),
            'tags' => Yii::t('app', 'Tags'),
            'languages'=>Yii::t('app', 'Languages'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Automatically remove fixed date and time from Sbb codes. Empty values are treated as 'now' by default.
            // dd.mm.yy = date, hh:mm = time. Replace with empty values.
            $pattern = array("/value=\"\d{2}\.\d{2}\.\d{2}\"/", "/value=\"\d{2}:\d{2}\"/");
            $replace = array("value=''", "value=''");
            $this->arrivalSbbCode = preg_replace($pattern, $replace, $this->arrivalSbbCode);
            // 'formular' is used as js selector, and expected to be unique.
            array_push($pattern, '/formular/');
            array_push($replace, 'formular_departure');
            $this->departureSbbCode = preg_replace($pattern, $replace, $this->departureSbbCode);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function afterSave($insert, $changedAttributes)
    {
    	if (empty($this->permaId))
        {
            $this->permaId = $this->id;
            $this->save();
        }
    }

    /**
     * Variable used to upload a geometry. This can be either a GeoJSON or a GPX file
     */
    public $geomUpload;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaMasters()
    {
        return $this->hasMany(MediaMaster::className(), ['trailId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ContentStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrivalStationType0()
    {
        return $this->hasOne(StationType::className(), ['id' => 'arrivalStationType']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartureStationType0()
    {
        return $this->hasOne(StationType::className(), ['id' => 'departureStationType']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDifficulty0()
    {
        return $this->hasOne(TrailDifficulty::className(), ['id' => 'difficulty']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailContents()
    {
        return $this->hasMany(TrailContent::className(), ['trailId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagMasters()
    {
        return $this->hasMany(TagMaster::className(), ['trailId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidTimeMasters()
    {
        return $this->hasMany(ValidTimeMaster::className(), ['trailId' => 'id']);
    }
    
    /**
     * @return boolean
     */
    public function isInRucksack()
    {
    	$inRucksack = false;
    	$cookieName = "rucksack-". strtolower($this->tableName()) ."s";
    	if (isset($_COOKIE[$cookieName]))
    	{
    		$items = explode(",", $_COOKIE[$cookieName]);
    		$inRucksack = in_array($this->permaId, $items) ? true : false;
		}
		return $inRucksack;
    }

     /**
     * @param $post array
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveRelatedTags($post)
    {
        // It's easier to just batch delete and insert instead of calculating the diff first,
        // as we receive a complete list of tag ids anyhow.
        TagMaster::deleteAll(['trailId' => $this->id]);

        if (isset($post['ConvertedTrail']['relatedTags']))
        {
        	// This command expects values in the form of ['tagId', 'tagId2'], so we rebuild the array.
        	$tagIds = [];
        	foreach ($post['ConvertedTrail']['relatedTags'] as $tagId)
        	{
        		// Avoid self-relations
        		if ($this->id != $tagId)
        			$tagIds[] = [$this->id, $tagId];
        	}
        	Yii::$app->db->createCommand()->batchInsert('TagMaster', ['trailId', 'tagId'], $tagIds)->execute();
        }
        return true;
    }
    
    public function saveRelatedValidTimes($post)
    {
        ValidTimeMaster::deleteAll(['trailId' => $this->id]);
        
        if (isset($post['ConvertedTrail']['validTimes']))
        {
        	$validTimeIds = [];
        	foreach ($post['ConvertedTrail']['validTimes'] as $validTimeId)
        	{
				$validTimeIds[] = [$this->id, $validTimeId];
        	}
        	Yii::$app->db->createCommand()->batchInsert('ValidTimeMaster', ['trailId', 'validTimeId'], $validTimeIds)->execute();
        }
        return true;
    }
    
	public function getDifficulty()
	{
		foreach ($this->difficulty0->trailDifficultyContents as $difficulty)
		{
			if ($difficulty->languageId == \Yii::$app->params['preferredLanguageId'])
			{
				$difficulty =  $difficulty->difficultyName;
				break;
			}
		}
		return ucfirst($difficulty);
	}

	public function getDuration()
	{
		$h = gmdate("g", $this->durationInMin*60) ." ". Yii::t('frontend', 'Std.');
		$min = gmdate("i", $this->durationInMin*60);
		if ($min != "00")
		{
			$min = $min ." ". Yii::t('frontend', 'Min.');
		}
		else
			$min = "";
		
		return $h ." ". $min;
	}
	
	public function getDistanceInKm()
	{
		 return $this->distanceInKm .' '. Yii::t('frontend', 'km');
	}
	
	public function getCategoryName()
	{
		return Yii::t('frontend', 'Wanderung');
	}
}
