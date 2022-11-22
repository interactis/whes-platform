<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\TranslationModel;

/**
 * This is the model class for table "download".
 *
 * @property int $id
 * @property int|null $content_id
 * @property int|null $order
 * @property bool|null $hidden
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $content
 * @property DownloadTranslation[] $downloadTranslations
 */
class Download extends TranslationModel
{
	public $translationFields = ['title', 'description', 'file'];
	public $requiredTranslationFields = ['title'];
	public $fileField = 'file';
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'download';
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
    	foreach($this->downloadTranslations as $translation)
    	{
    		if (!empty($translation->filename))
    		{
    			$path = Yii::getAlias('@frontend/web/file/download/'. $translation->language->code .'/'. $translation->filename);
    			if (file_exists($path))
					unlink($path);
    		}
    	}	
    }
    
    public function getFileUrl()
    {
    	return Yii::$app->params['frontendUrl'] .'file/download/'. $this->language->code .'/'. $this->filename .'?'. Yii::$app->security->generateRandomString(6);	
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
     * Gets query for [[DownloadTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDownloadTranslations()
    {
        return $this->hasMany(DownloadTranslation::className(), ['download_id' => 'id']);
    }
}
