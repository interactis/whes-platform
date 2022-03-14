<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ExhibitType".
 *
 * @property integer $id
 * @property string $typeName
 *
 * @property Exhibit[] $exhibits
 */
class ExhibitType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ExhibitType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typeName'], 'required'],
            [['typeName'], 'string', 'max' => 50],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibits()
    {
        return $this->hasMany(Exhibit::className(), ['type' => 'id']);
    }
}
