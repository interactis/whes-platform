<?php

namespace common\models;

use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\Html;

class Ambassador extends \yii\db\ActiveRecord
{

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
            [['type', 'status'], 'required'],
            [['permaId', 'type', 'status'], 'integer'],
            [['creationTime'], 'safe'],
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
            'status' => Yii::t('app', 'Status'),
            'creationTime' => Yii::t('app', 'Creation Time'),
            'geom' => Yii::t('app', 'Geom'),
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
    public function getAmbassadorContent()
    {
        return $this->hasOne(AmbassadorContent::className(), ['poiId' => 'id']);
    }
    
    /**
     * @param $geom
     * Store array to postgis geometry field.
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;
    }
    
}
