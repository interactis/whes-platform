<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ExhibitionCodeSeries".
 *
 * @property integer $id
 * @property integer $codeCount
 * @property string $creationTime
 *
 * @property ExhibitionCode[] $exhibitionCodes
 */
class ExhibitionCodeSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ExhibitionCodeSeries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codeCount'], 'integer'],
            [['codeCount'], 'required'],
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
            'codeCount' => Yii::t('app', 'Code Count'),
            'creationTime' => Yii::t('app', 'Creation Time'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->isNewRecord)
                $this->creationTime = new \yii\db\Expression('NOW()');
            
            return true;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionCodes()
    {
        return $this->hasMany(ExhibitionCode::className(), ['exhibitionCodeSeriesId' => 'id']);
    }
}
