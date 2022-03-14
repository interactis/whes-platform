<?php

namespace common\models\mysa;

use Yii;
use common\components\validators\DefaultLanguageValidator;
use common\components\validators\RegisterAvailableTranslationsValidator;
use common\components\validators\TranslationsValidator;

/**
 * This is the model class for table "StoryContent".
 *
 * @property integer $id
 * @property integer $storyId
 * @property integer $languageId
 * @property string $title
 * @property string $excerpt
 * @property string $story
 *
 * @property Language $language
 * @property Story $story0
 */
class StoryContent extends \yii\db\ActiveRecord
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
        return 'StoryContent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languageId'], 'required'],
            [['storyId', 'languageId'], 'integer'],
            [['title', 'excerpt', 'story'], 'string'],
            [['title', 'excerpt', 'story'], DefaultLanguageValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
           	[['title', 'excerpt', 'story'], RegisterAvailableTranslationsValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
            [['title', 'excerpt', 'story'], TranslationsValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'storyId' => Yii::t('app', 'Story ID'),
            'languageId' => Yii::t('app', 'Language ID'),
            'title' => Yii::t('app', 'Title'),
            'excerpt' => Yii::t('app', 'Excerpt'),
            'story' => Yii::t('app', 'Story'),
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
    public function getStory0()
    {
        return $this->hasOne(Story::className(), ['id' => 'storyId']);
    }
}
