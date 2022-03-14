<?php

namespace common\models;

use Yii;
use common\components\validators\DefaultLanguageValidator;
use common\components\validators\RegisterAvailableTranslationsValidator;
use common\components\validators\TranslationsValidator;

/**
 * This is the model class for table "TrailContent".
 *
 * @property integer $id
 * @property integer $trailId
 * @property integer $languageId
 * @property string $title
 * @property string $description
 * @property string $catering
 * @property string $accommodation
 * @property string $generalRemarks
 * @property string $options
 *
 * @property Language $language
 * @property Trail $trail
 */
class TrailContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TrailContent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languageId'], 'required'],
            [['trailId', 'languageId'], 'integer'],
            [['title', 'description', 'catering', 'accommodation', 'generalRemarks', 'options'], 'string'],
            [['title', 'description'], DefaultLanguageValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
           	[['title', 'description', 'catering', 'accommodation', 'generalRemarks', 'options'], RegisterAvailableTranslationsValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
           	[['title', 'description', 'catering', 'accommodation', 'generalRemarks', 'options'], TranslationsValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'trailId' => Yii::t('app', 'Trail ID'),
            'languageId' => Yii::t('app', 'Language ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'catering' => Yii::t('app', 'Catering'),
            'accommodation' => Yii::t('app', 'Accommodation'),
            'generalRemarks' => Yii::t('app', 'General Remarks'),
            'options' => Yii::t('app', 'Options'),
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
    public function getTrail()
    {
        return $this->hasOne(Trail::className(), ['id' => 'trailId']);
    }
}
