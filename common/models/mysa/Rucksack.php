<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "Rucksack".
 *
 * @property integer $id
 * @property string $code
 * @property string $creationTime
 * @property string $wnfAccessTime
 * @property string $webAccessTime
 *
 * @property RucksackMaster[] $rucksackMasters
 */
class Rucksack extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Rucksack';
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
        	['code', 'filter', 'filter' => function ($value)
        	{
        		// strip spaces and make it case insensitive
        		return preg_replace('/\s+/', '', strtolower($value));
    		}],
            [['code'], 'unique'],
            [['code'], 'string', 'min' => 4, 'max' => 4],
            [['creationTime', 'wnfAccessTime', 'webAccessTime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'creationTime' => Yii::t('app', 'Creation Time'),
            'wnfAccessTime' => Yii::t('app', 'Wnf Access Time'),
            'webAccessTime' => Yii::t('app', 'Web Access Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRucksackMasters()
    {
        return $this->hasMany(RucksackMaster::className(), ['rucksackId' => 'id']);
    }
}
