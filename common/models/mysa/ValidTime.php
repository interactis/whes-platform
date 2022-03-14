<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ValidTime".
 *
 * @property integer $id
 * @property string $startTime
 * @property integer $startDay
 * @property integer $startMonth
 * @property integer $startYear
 * @property string $endTime
 * @property integer $endDay
 * @property integer $endMonth
 * @property integer $endYear
 * @property integer $reuse
 * @property string $title
 *
 * @property ValidTimeMaster[] $validTimeMasters
 */
class ValidTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ValidTime';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['startTime', 'endTime'], 'safe'],
            [['startDay', 'startMonth', 'startYear', 'endDay', 'endMonth', 'endYear', 'reuse'], 'integer'],
            [['reuse'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'startTime' => Yii::t('app', 'Start Time'),
            'startDay' => Yii::t('app', 'Start Day'),
            'startMonth' => Yii::t('app', 'Start Month'),
            'startYear' => Yii::t('app', 'Start Year'),
            'endTime' => Yii::t('app', 'End Time'),
            'endDay' => Yii::t('app', 'End Day'),
            'endMonth' => Yii::t('app', 'End Month'),
            'endYear' => Yii::t('app', 'End Year'),
            'reuse' => Yii::t('app', 'Reuse'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidTimeMasters()
    {
        return $this->hasMany(ValidTimeMaster::className(), ['validTimeId' => 'id']);
    }
}
