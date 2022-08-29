<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "audio_translation".
 *
 * @property int $id
 * @property int|null $audio_id
 * @property int|null $language_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $filename
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Audio $audio
 * @property Language $language
 */
class AudioTranslation extends \yii\db\ActiveRecord
{
	public $file;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audio_translation';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['audio_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['audio_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title', 'filename'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 180],
            [['audio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Audio::className(), 'targetAttribute' => ['audio_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        	['file', 'file', 'extensions' => 'mp3'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'audio_id' => Yii::t('app', 'Audio ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'filename' => Yii::t('app', 'Filename'),
            'file' => Yii::t('app', 'File Upload'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Audio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAudio()
    {
        return $this->hasOne(Audio::className(), ['id' => 'audio_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
