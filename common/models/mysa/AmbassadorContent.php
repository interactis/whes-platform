<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "AmbassadorContent".
 *
 * @property integer $id
 * @property integer $poiId
 * @property integer $type
 * @property string $firstName
 * @property string $lastName
 * @property string $zip
 * @property string $city
 * @property string $favoritePlace
 * @property string $quote
 * @property string $imageName
 *
 * @property AmbassadorType $type0
 * @property Poi $poi
 */
class AmbassadorContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AmbassadorContent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['poiId', 'type', 'firstName', 'favoritePlace'], 'required'],
            [['poiId', 'type'], 'integer'],
            [['quote'], 'string'],
            [['firstName', 'lastName', 'favoritePlace'], 'string', 'max' => 150],
            [['zip'], 'string', 'max' => 6],
            [['city'], 'string', 'max' => 70],
            [['imageName'], 'string', 'max' => 36],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => AmbassadorType::className(), 'targetAttribute' => ['type' => 'id']],
            [['poiId'], 'exist', 'skipOnError' => true, 'targetClass' => Poi::className(), 'targetAttribute' => ['poiId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'poiId' => Yii::t('app', 'Poi ID'),
            'type' => Yii::t('app', 'Type'),
            'firstName' => Yii::t('app', 'First Name / Company Name'),
            'lastName' => Yii::t('app', 'Last Name'),
            'zip' => Yii::t('app', 'Zip'),
            'city' => Yii::t('app', 'City'),
            'favoritePlace' => Yii::t('app', 'Favorite Place'),
            'quote' => Yii::t('app', 'Quote'),
            'imageName' => Yii::t('app', 'Image Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(AmbassadorType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoi()
    {
        return $this->hasOne(Poi::className(), ['id' => 'poiId']);
    }
}
