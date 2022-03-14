<?php

namespace common\models\mysa;

use Yii;

/**
 * This is the model class for table "PoiType".
 *
 * @property integer $id
 * @property string $typeName
 *
 * @property Poi[] $pois
 */
class PoiType extends \yii\db\ActiveRecord
{
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PoiType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typeName'], 'required'],
            [['typeName'], 'string', 'max' => 50]
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
    public function getPois()
    {
        return $this->hasMany(Poi::className(), ['type' => 'id']);
    }
}
