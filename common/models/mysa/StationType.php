<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "StationType".
 *
 * @property integer $id
 * @property string $typeName
 * @property string $iconPath
 *
 * @property Trail[] $trails
 * @property Trail[] $trails0
 */
class StationType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'StationType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iconPath'], 'required'],
            [['typeName'], 'string', 'max' => 50],
            [['iconPath'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'typeName' => Yii::t('app', 'Type Name'),
            'iconPath' => Yii::t('app', 'Icon Path'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrails()
    {
        return $this->hasMany(Trail::className(), ['arrivalStationType' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrails0()
    {
        return $this->hasMany(Trail::className(), ['departureStationType' => 'id']);
    }
}
