<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\TranslationModel;

/**
 * This is the model class for table "audio".
 *
 * @property int $id
 * @property int|null $content_id
 * @property int|null $order
 * @property bool|null $hidden
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $content
 * @property AudioTranslation[] $audioTranslations
 */
class Audio extends TranslationModel
{
	public $translationFields = ['title', 'description', 'file'];
	public $requiredTranslationFields = ['title'];
	public $fileField = 'file';
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audio';
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
            [['content_id', 'order', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'order', 'created_at', 'updated_at'], 'integer'],
            [['hidden'], 'boolean'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'order' => Yii::t('app', 'Order'),
            'hidden' => Yii::t('app', 'Hidden'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function removeFiles()
    {
    	foreach($this->audioTranslations as $translation)
    	{
    		if (!empty($translation->filename))
    		{
    			$path = Yii::getAlias('@frontend/web/file/audio/'. $translation->language->code .'/'. $translation->filename);
    			if (file_exists($path))
					unlink($path);
    		}
    	}	
    }
    
    /**
     * Gets query for [[Content]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * Gets query for [[AudioTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAudioTranslations()
    {
        return $this->hasMany(AudioTranslation::className(), ['audio_id' => 'id']);
    }
}
