<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "heritage_translation".
 *
 * @property int $id
 * @property int|null $heritage_id
 * @property int|null $language_id
 * @property string|null $slug
 * @property string|null $name
 * @property string|null $short_name
 * @property string|null $description
 * @property string|null $link_url
 * @property string|null $link_text
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Heritage $heritage
 * @property Language $language
 */
class HeritageTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'heritage_translation';
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
            [['heritage_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['heritage_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['slug', 'name', 'short_name', 'link_url', 'link_text'], 'string', 'max' => 255],
            [['heritage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Heritage::className(), 'targetAttribute' => ['heritage_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        	[['link_url'], 'url'],
        	
        	[['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-z][-a-z0-9]*$/', 'message' => Yii::t('app', 'Slug can contain only small letters, numbers and -')],
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
            'language_id' => Yii::t('app', 'Language ID'),
            'slug' => Yii::t('app', 'Slug'),
            'name' => Yii::t('app', 'Name'),
            'short_name' => Yii::t('app', 'Short Name'),
            'description' => Yii::t('app', 'Description'),
            'link_url' => Yii::t('app', 'Link URL'),
            'link_text' => Yii::t('app', 'Link Text'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
}
