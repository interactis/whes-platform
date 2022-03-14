<?php

namespace common\models\mysa;

use Yii;

/**
 * This is the model class for table "TrailDifficulty".
 *
 * @property integer $id
 *
 * @property Trail[] $trails
 * @property TrailDifficultyContent[] $trailDifficultyContents
 */
class TrailDifficulty extends TranslatedModel
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
        return 'TrailDifficulty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrails()
    {
        return $this->hasMany(Trail::className(), ['difficulty' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailDifficultyContents()
    {
        return $this->hasMany(TrailDifficultyContent::className(), ['trailDifficultyId' => 'id']);
    }
}
