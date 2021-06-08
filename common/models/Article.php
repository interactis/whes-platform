<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int|null $content_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $content
 * @property ArticleTranslation[] $articleTranslations
 */
class Article extends HelperModel
{
	public $translationFields = ['title', 'excerpt', 'description', 'youtube_id'];
	public $requiredTranslationFields = ['title', 'excerpt'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }
    
    public static function pluralName()
    {
    	return Yii::t('app', 'Articles');
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
            [['content_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'created_at', 'updated_at'], 'integer'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['tags', 'flags'], 'required'],
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
            'flags' =>  Yii::t('app', 'Filters'),
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
     * Gets query for [[ArticleTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTranslations()
    {
        return $this->hasMany(ArticleTranslation::className(), ['article_id' => 'id']);
    }
    
    public function getLabel()
    {
    	$html = $this->getFlagLabel(Yii::t('app', 'Good to Know'));
    	
    	if (isset($this->content->heritage))
    		$html .= '<br /><em>'. $this->content->heritage->short_name .'</em>';
    		
    	return $html;
    }
}
