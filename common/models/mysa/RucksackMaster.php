<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "RucksackMaster".
 *
 * @property integer $id
 * @property integer $rucksackId
 * @property integer $poiId
 * @property integer $storyId
 * @property integer $trailId
 * @property integer $tagId
 * @property integer $exhibitId 
 * @property string $creationTime
 *
 * @property Exhibit $exhibit 
 * @property Poi $poi
 * @property Rucksack $rucksack
 * @property Story $story
 * @property Tag $tag
 * @property Trail $trail
 */
class RucksackMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'RucksackMaster';
    }
    
    public function behaviors()
	{
    	return [
    	    [
    	        'class' => TimestampBehavior::className(),
    	        'createdAtAttribute' => 'creationTime',
    	        'updatedAtAttribute' => false,
    	        'value' => new Expression('NOW()'),
    	    ],
    	];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rucksackId'], 'required'],
            [['rucksackId', 'poiId', 'storyId', 'trailId', 'tagId', 'exhibitId'], 'integer'],
            [['creationTime'], 'safe'],
            [['exhibitId'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibit::className(), 'targetAttribute' => ['exhibitId' => 'id']],
		    [['poiId'], 'exist', 'skipOnError' => true, 'targetClass' => Poi::className(), 'targetAttribute' => ['poiId' => 'id']],
		    [['rucksackId'], 'exist', 'skipOnError' => true, 'targetClass' => Rucksack::className(), 'targetAttribute' => ['rucksackId' => 'id']],
		    [['storyId'], 'exist', 'skipOnError' => true, 'targetClass' => Story::className(), 'targetAttribute' => ['storyId' => 'id']],
		    [['tagId'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tagId' => 'id']],
		    [['trailId'], 'exist', 'skipOnError' => true, 'targetClass' => Trail::className(), 'targetAttribute' => ['trailId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'rucksackId' => Yii::t('app', 'Rucksack ID'),
            'poiId' => Yii::t('app', 'Poi ID'),
            'storyId' => Yii::t('app', 'Story ID'),
            'trailId' => Yii::t('app', 'Trail ID'),
            'tagId' => Yii::t('app', 'Tag ID'),
            'exhibitId' => Yii::t('app', 'Exhibit ID'),
            'creationTime' => Yii::t('app', 'Creation Time'),
        ];
    }
	
	/** 
	 * @return \yii\db\ActiveQuery 
	 */ 
	public function getExhibit() 
	{ 
		return $this->hasOne(Exhibit::className(), ['id' => 'exhibitId']); 
	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoi()
    {
        return $this->hasOne(Poi::className(), ['id' => 'poiId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRucksack()
    {
        return $this->hasOne(Rucksack::className(), ['id' => 'rucksackId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStory()
    {
        return $this->hasOne(Story::className(), ['id' => 'storyId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tagId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrail()
    {
        return $this->hasOne(Trail::className(), ['id' => 'trailId']);
    }
}
