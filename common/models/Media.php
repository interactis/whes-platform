<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property int|null $heritage_id
 * @property int|null $content_id
 * @property int|null $page_id
 * @property string|null $filename
 * @property string|null $exif
 * @property int|null $order
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $content
 * @property Heritage $heritage
 * @property Page $page
 * @property MediaTranslation[] $mediaTranslations
 */
class Media extends HelperModel
{
	public $translationFields = ['title', 'description', 'copyright'];
	public $requiredTranslationFields = ['title', 'description'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
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
            [['heritage_id', 'content_id', 'page_id', 'order', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['heritage_id', 'content_id', 'page_id', 'order', 'created_at', 'updated_at'], 'integer'],
            [['exif'], 'string'],
            [['filename'], 'string', 'max' => 255],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['heritage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Heritage::className(), 'targetAttribute' => ['heritage_id' => 'id']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'heritage_id' => Yii::t('app', 'Heritage ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'page_id' => Yii::t('app', 'Page ID'),
            'filename' => Yii::t('app', 'Filename'),
            'exif' => Yii::t('app', 'Exif'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
     * Gets query for [[Heritage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeritage()
    {
        return $this->hasOne(Heritage::className(), ['id' => 'heritage_id']);
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * Gets query for [[MediaTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMediaTranslations()
    {
        return $this->hasMany(MediaTranslation::className(), ['media_id' => 'id']);
    }
}
