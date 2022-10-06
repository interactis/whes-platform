<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "download_translation".
 *
 * @property int $id
 * @property int|null $download_id
 * @property int|null $language_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $filename
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Download $download
 * @property Language $language
 */
class DownloadTranslation extends \yii\db\ActiveRecord
{
	public $file;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'download_translation';
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
            [['download_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['download_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title', 'filename'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 180],
            [['download_id'], 'exist', 'skipOnError' => true, 'targetClass' => Download::className(), 'targetAttribute' => ['download_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        	['file', 'file', 'extensions' => 'pdf, zip, gz', 'maxSize' => 1024 * 1024 * 10] // 10 MB
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'download_id' => Yii::t('app', 'Download ID'),
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
     * Gets query for [[Download]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDownload()
    {
        return $this->hasOne(Download::className(), ['id' => 'download_id']);
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
