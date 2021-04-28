<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\TranslationModel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property bool|null $active
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property ContentTag[] $contentTags
 * @property TagTranslation[] $tagTranslations
 */
class Tag extends TranslationModel
{
	public $translationFields = ['title'];
	public $requiredTranslationFields = ['title'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
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
            [['active'], 'boolean'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ContentTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentTags()
    {
        return $this->hasMany(ContentTag::className(), ['tag_id' => 'id']);
    }
	
	public function getRelatedTags()
    {
        return $this->hasMany(RelatedTag::className(), ['tag_id' => 'id']);
    }
    
    public function getRelatingTags()
    {
        return $this->hasMany(RelatedTag::className(), ['related_tag_id' => 'id']);
    }
	
    /**
     * Gets query for [[TagTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagTranslations()
    {
        return $this->hasMany(TagTranslation::className(), ['tag_id' => 'id']);
    }
    
    public static function getTagList()
    {
    	$models = Tag::find()
    		->joinWith('tagTranslations')
    		->orderBy('title')
    		->all();
    		
        return ArrayHelper::map($models, 'id', 'title');
    }
}
