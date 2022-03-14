<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "AmbassadorType".
 *
 * @property integer $id
 * @property string $typeName
 *
 * @property AmbassadorContent[] $ambassadorContents
 */
class AmbassadorType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AmbassadorType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
    public function getAmbassadorContents()
    {
        return $this->hasMany(AmbassadorContent::className(), ['type' => 'id']);
    }
}
