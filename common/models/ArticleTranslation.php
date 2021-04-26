<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article_translation".
 *
 * @property int $id
 * @property int|null $article_id
 * @property int|null $language_id
 * @property string|null $slug
 * @property string|null $title
 * @property string|null $excerpt
 * @property string|null $description
 * @property string|null $youtube_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Article $article
 * @property Language $language
 */
class ArticleTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_translation';
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
            [['article_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['article_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['excerpt', 'description'], 'string'],
            [['slug', 'title', 'youtube_id'], 'string', 'max' => 255],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'article_id' => Yii::t('app', 'Article ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'excerpt' => Yii::t('app', 'Excerpt'),
            'description' => Yii::t('app', 'Description'),
            'youtube_id' => Yii::t('app', 'Youtube ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
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
