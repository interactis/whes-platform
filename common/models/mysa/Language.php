<?php

namespace common\models\mysa;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Language".
 *
 * @property integer $id
 * @property string $languageCode
 * @property string $language
 *
 * @property MediaDescription[] $mediaDescriptions
 * @property PoiContent[] $poiContents
 * @property StoryContent[] $storyContents
 * @property TrailContent[] $trailContents
 * @property TrailDifficultyContent[] $trailDifficultyContents
 */
class Language extends \yii\db\ActiveRecord
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
        return 'Language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languageCode', 'language'], 'required'],
            [['languageCode'], 'string', 'max' => 4],
            [['language'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'languageCode' => Yii::t('app', 'Language Code'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaDescriptions()
    {
        return $this->hasMany(MediaDescription::className(), ['languageId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoiContents()
    {
        return $this->hasMany(PoiContent::className(), ['languageId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoryContents()
    {
        return $this->hasMany(StoryContent::className(), ['languageId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailContents()
    {
        return $this->hasMany(TrailContent::className(), ['languageId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailDifficultyContents()
    {
        return $this->hasMany(TrailDifficultyContent::className(), ['languageId' => 'id']);
    }

    /**
     * @return array ['languageCode' => 'language'] for all existing languages.
     */
    public static function getLanguageNames($key='languageCode', $val='language')
    {
        $languages = call_user_func(self::className().'::find')->all();
        return ArrayHelper::map($languages, $key, $val);
    }
}
