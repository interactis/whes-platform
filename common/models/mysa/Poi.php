<?php

namespace common\models\mysa;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "Poi".
 *
 * @property integer $id
 * @property integer $permaId
 * @property integer $type
 * @property string $authorName
 * @property string $authorUrl
 * @property string $supplierStreet
 * @property string $supplierStreetNumber
 * @property string $supplierZip
 * @property string $supplierCity
 * @property string $supplierUrl
 * @property string $supplierEmail
 * @property string $supplierTel
 * @property integer $status
 * @property string $creationTime
 * @property integer $recommended
 * @property integer $forFamilies
 * @property string $geom
 * @property string $arrivalStation
 * @property integer $arrivalStationType
 * @property string $arrivalSbbCode
 * @property string $departureStation
 * @property integer $departureStationType
 * @property string $departureSbbCode
 *
 * @property MediaMaster[] $mediaMasters
 * @property ContentStatus $status0
 * @property PoiType $type0
 * @property PoiContent[] $poiContents
 * @property ValidTimeMaster[] $validTimeMasters
 */
class Poi extends TranslatedModel
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
        return 'Poi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'relatedTags', 'validTimes'], 'required'],
            [['permaId', 'type', 'status', 'recommended', 'forFamilies', 'arrivalStationType', 'departureStationType'], 'integer'],
            [['creationTime'], 'safe'],
//            [['geom'], 'string'],
            [['authorName'], 'string', 'max' => 150],
            [['authorUrl', 'supplierUrl', 'supplierEmail'], 'string', 'max' => 200],
            [['supplierStreet'], 'string', 'max' => 100],
            [['supplierStreetNumber', 'supplierZip'], 'string', 'max' => 10],
            [['supplierCity'], 'string', 'max' => 70],
            [['supplierTel'], 'string', 'max' => 50],
            [['arrivalStation', 'departureStation'], 'string', 'max' => 255],
            [['arrivalSbbCode', 'departureSbbCode'], 'string']
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
            'type' => Yii::t('app', 'Type'),
            'authorName' => Yii::t('app', 'Author Name'),
            'authorUrl' => Yii::t('app', 'Author Url'),
            'supplierStreet' => Yii::t('app', 'Supplier Street'),
            'supplierStreetNumber' => Yii::t('app', 'Supplier Street Number'),
            'supplierZip' => Yii::t('app', 'Supplier Zip'),
            'supplierCity' => Yii::t('app', 'Supplier City'),
            'supplierUrl' => Yii::t('app', 'Supplier Url'),
            'supplierEmail' => Yii::t('app', 'Supplier Email'),
            'supplierTel' => Yii::t('app', 'Supplier Tel'),
            'status' => Yii::t('app', 'Status'),
            'creationTime' => Yii::t('app', 'Creation Time'),
            'recommended' => Yii::t('app', 'Recommended'),
            'forFamilies' => Yii::t('app', 'For Families'),
            'geom' => Yii::t('app', 'Geom'),
            'arrivalStation' => Yii::t('app', 'Arrival Station'),
            'arrivalStationType' => Yii::t('app', 'Arrival Station Type'),
            'arrivalSbbCode' => Yii::t('app', 'Arrival SBB Code'),
            'departureStation' => Yii::t('app', 'Departure Station'),
            'departureStationType' => Yii::t('app', 'Departure Station Type'),
            'departureSbbCode' => Yii::t('app', 'Departure SBB Code'),
            /* Other labels, used for search */
            'title'=>Yii::t('app', 'Title'),
            'tags'=>Yii::t('app', 'Tags'),
            'languages'=>Yii::t('app', 'Languages'),
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getMediaMasters()
    {
        return $this->hasMany(MediaMaster::className(), ['poiId' => 'id']);
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
    public function getType0()
    {
        return $this->hasOne(PoiType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagMasters()
    {
        return $this->hasMany(TagMaster::className(), ['poiId' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidTimeMasters()
    {
        return $this->hasMany(ValidTimeMaster::className(), ['poiId' => 'id']);
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
    public function getPoiContents()
    {
        return $this->hasMany(PoiContent::className(), ['poiId' => 'id']);
    }

    public function getPoiContent()
    {
        return $this->getPoiContents()->one();
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
     * @param $tagIds array
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveRelatedTags($post)
    {
        // It's easier to just batch delete and insert instead of calculating the diff first,
        // as we receive a complete list of tag ids anyhow.
        TagMaster::deleteAll(['poiId' => $this->id]);
        
        if (isset($post['ConvertedPoi']['relatedTags']))
        {
        	// This command expects values in the form of ['tagId', 'tagId2'], so we rebuild the array.
        	$tagIds = [];
        	foreach ($post['ConvertedPoi']['relatedTags'] as $tagId)
        	{
        		// Avoid self-relations
        		if ($this->id != $tagId)
        			$tagIds[] = [$this->id, $tagId];
        	}
        	Yii::$app->db->createCommand()->batchInsert('TagMaster', ['poiId', 'tagId'], $tagIds)->execute();
        }
        return true;
    }
    
    public function saveRelatedValidTimes($post)
    {
        ValidTimeMaster::deleteAll(['poiId' => $this->id]);
        
        if (isset($post['ConvertedPoi']['validTimes']))
        {
        	$validTimeIds = [];
        	foreach ($post['ConvertedPoi']['validTimes'] as $validTimeId)
        	{
				$validTimeIds[] = [$this->id, $validTimeId];
        	}
        	Yii::$app->db->createCommand()->batchInsert('ValidTimeMaster', ['poiId', 'validTimeId'], $validTimeIds)->execute();
        }
        return true;
	}

    /**
     * @param $geom
     * Store array to postgis geometry field.
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;
    }
    
    public function getCategoryName()
	{
		if ($this->type == 3)
		{
			return Yii::t('frontend', 'Ausflugsziel');
		}
		else
			return Yii::t('frontend', 'Interessanter Ort');
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
}
