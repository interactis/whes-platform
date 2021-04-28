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
	
	public $tags = [];
	
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
            [['tags'], 'safe'],
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
            'tags' => Yii::t('app', 'Related Tags'),
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
    
    public function saveTags()
    {
        RelatedTag::deleteAll(['tag_id' => $this->id]);
    	
		$tagIds = [];
		foreach ($this->tags as $tagId)
		{
			if ($this->id != $tagId && is_numeric($tagId))
			{
				if (Tag::findOne($tagId))
					$tagIds[] = [$this->tag_id, $tagId];
			}
				
		}
		Yii::$app->db->createCommand()->batchInsert('related_tag', ['tag_id', 'related_tag_id'], $tagIds)->execute();
        
        return true;
    }
}
