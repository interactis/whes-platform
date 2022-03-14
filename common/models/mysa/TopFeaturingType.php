<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "TopFeaturingType".
 *
 * @property integer $id
 * @property string $typeName
 *
 * @property TopFeaturing[] $topFeaturings
 */
class TopFeaturingType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TopFeaturingType';
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
    public function getTopFeaturings()
    {
        return $this->hasMany(TopFeaturing::className(), ['type' => 'id']);
    }
}
