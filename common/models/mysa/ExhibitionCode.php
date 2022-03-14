<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ExhibitionCode".
 *
 * @property integer $id
 * @property integer $exhibitionCodeSeriesId
 * @property string $code
 *
 * @property ExhibitionCodeSeries $exhibitionCodeSeries
 */
class ExhibitionCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ExhibitionCode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['exhibitionCodeSeriesId', 'code'], 'required'],
            [['exhibitionCodeSeriesId'], 'integer'],
            [['code'], 'string', 'max' => 6],
            [['code'], 'unique'],
            [['exhibitionCodeSeriesId'], 'exist', 'skipOnError' => true, 'targetClass' => ExhibitionCodeSeries::className(), 'targetAttribute' => ['exhibitionCodeSeriesId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'exhibitionCodeSeriesId' => Yii::t('app', 'Exhibition Code Series ID'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionCodeSeries()
    {
        return $this->hasOne(ExhibitionCodeSeries::className(), ['id' => 'exhibitionCodeSeriesId']);
    }
}
