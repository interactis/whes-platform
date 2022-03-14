<?php

namespace common\models\mysa;

use Yii;

/**
 * This is the model class for table "TrailDifficultyContent".
 *
 * @property integer $id
 * @property integer $trailDifficultyId
 * @property integer $languageId
 * @property string $difficultyName
 *
 * @property Language $language
 * @property TrailDifficulty $trailDifficulty
 */
class TrailDifficultyContent extends \yii\db\ActiveRecord
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
        return 'TrailDifficultyContent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trailDifficultyId', 'languageId', 'difficultyName'], 'required'],
            [['trailDifficultyId', 'languageId'], 'integer'],
            [['difficultyName'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'trailDifficultyId' => Yii::t('app', 'Trail Difficulty ID'),
            'languageId' => Yii::t('app', 'Language ID'),
            'difficultyName' => Yii::t('app', 'Difficulty Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'languageId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailDifficulty()
    {
        return $this->hasOne(TrailDifficulty::className(), ['id' => 'trailDifficultyId']);
    }
}
