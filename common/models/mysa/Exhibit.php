<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Exhibit".
 *
 * @property integer $id
 * @property integer $permaId
 * @property integer $poiId
 * @property integer $tagId
 * @property boolean $active
 * @property string $creationTime
 * @property integer $type
 *
 * @property ExhibitType $type0
 * @property Poi $poi
 * @property Tag $tag
 * @property RucksackMaster[] $rucksackMasters
 */
class Exhibit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Exhibit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permaId', 'poiId', 'tagId', 'type'], 'integer'],
            [['active'], 'boolean'],
            [['type', 'permaId'], 'required'],
            [['creationTime'], 'safe'],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => ExhibitType::className(), 'targetAttribute' => ['type' => 'id']],
            [['poiId'], 'exist', 'skipOnError' => true, 'targetClass' => Poi::className(), 'targetAttribute' => ['poiId' => 'id']],
            [['tagId'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tagId' => 'id']],
            [['permaId'], 'permaIdValidation', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }
	
	public function permaIdValidation($attribute, $params)
    {
    	// permaId/exhibitId cannot be created twice
    	if ($this->isNewRecord)
    	{
    		$exists = Exhibit::find()->where(['permaId' => $this->$attribute, 'active' => true] )->exists(); 
    		if ($exists)
    			$this->addError($attribute, $this->getAttributeLabel($attribute) .' "'. $this->$attribute .'" has already been taken.');
    	}
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'permaId' => Yii::t('app', 'Exhibit ID'),
            'poiId' => Yii::t('app', 'Related POI'),
            'tagId' => Yii::t('app', 'Related Tag'),
            'active' => Yii::t('app', 'Active'),
            'creationTime' => Yii::t('app', 'Creation Time'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
	
	public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->type == 1) // poi
    		{
    			$this->tagId = null; // reset tagId
    		}
    		else
    			$this->poiId = null; // reset poiId
         	
            if ($this->isNewRecord)
            {
                $this->creationTime = new \yii\db\Expression('NOW()');
            }
            
            return true;
        }
    }
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getType0()
	{
		return $this->hasOne(ExhibitType::className(), ['id' => 'type']);
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
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tagId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRucksackMasters()
    {
        return $this->hasMany(RucksackMaster::className(), ['exhibitId' => 'id']);
    }
}
