<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "Tag".
 *
 * @property integer $id
 * @property integer $permaId
 * @property boolean $active
 * @property integer $status
 * @property integer $featured
 * @property integer $recommended
 * @property string $creationTime
 *
 * @property MediaMaster[] $mediaMasters
 * @property ContentStatus $status0
 * @property TagContent[] $tagContents
 */
class Tag extends TranslatedModel
{
	public $images = [];
		
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permaId', 'status', 'featured', 'recommended'], 'integer'],
            [['status', 'featured', 'recommended', 'active'], 'required'],
            [['creationTime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'permaId' => Yii::t('app', 'Perma ID'),
            'active' => Yii::t('app', 'Active'),
            'status' => Yii::t('app', 'Featured Status'),
            'featured' => Yii::t('app', 'Featured'),
            'recommended' => Yii::t('app', 'Recommended'),
            'creationTime' => Yii::t('app', 'Creation Time'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
    	if (empty($this->permaId))
        {
            $this->permaId = $this->id;
            $this->save();
        }
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaMasters()
    {
        return $this->hasMany(MediaMaster::className(), ['tagId' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ContentStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     *
     * @maybe: refactor this. I have no idea if this is considered to be 'ok' within yii2.
     */
    public function getTagContents()
    {
        return $this->hasMany(TagContent::className(), ['tagId' => 'id']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagMasters()
    {
        return $this->hasMany(TagMaster::className(), ['tagId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedTags()
    {
        return $this->getRelatedTagsFromMaster('tagId');
    }

    public function getTagsRelatingToThis()
    {
        return $this->getRelatedTagsFromMaster('tagId2');
    }

    /**
     * @param string $joinField
     * @return \yii\db\ActiveQuery
     * pass either 'tagId' or 'tagId2' to receive any related tags. 'tagId' stands for a 'forward' relation (= this tag
     * has a relation to the following tags), while 'tagId2' stands for a 'backward' relation (= this tag is related to
     * from these tags).
     */
    private function getRelatedTagsFromMaster($joinField)
    {
        $otherIdField = ($joinField == 'tagId') ? 'tagId2' : 'tagId';
        $subQuery = TagMaster::find()->select($otherIdField)->where([$joinField => $this->id])->andWhere(['!=', $otherIdField, 0]);
        return Tag::find()->where(['in', 'id', $subQuery]);
    }

    public function getRelatedTagNames()
    {
        $tagNames = [];
        foreach($this->getRelatedTags()->all() as $tag)
        {
            $tagNames[] = $tag->name;
        }
        return implode(', ', $tagNames);
    }
    
    /**
     * @return boolean
     */
    public function isInRucksack()
    {   
    	$inRucksack = false;
    	$cookieName = "rucksack-". strtolower($this->tableName()) ."s";
    	if (isset($_COOKIE[$cookieName]))
    	{
    		$items = explode(",", $_COOKIE[$cookieName]);
    		$inRucksack = in_array($this->permaId, $items) ? true : false;
		}
		return $inRucksack;
    }

    /**
     * @param $tagIds array
     * @return bool
     * @throws \yii\db\Exception
     * Stores relations between the current tag and given array of tag ids.
     */
    public function saveRelatedTags($post)
    {
        // It's easier to just batch delete and insert instead of calculating the diff first,
        // as we receive a complete list of tag ids anyhow.
        TagMaster::deleteAll(['tagId' => $this->id]);
        
        if (isset($post['relatedTags']))
        {
        	// This command expects values in the form of ['tagId', 'tagId2'], so we rebuild the array.
        	$tagIds = [];
        	foreach ($post['relatedTags'] as $tagId)
        	{
        		// Avoid self-relations
        		if ($this->id != $tagId)
        			$tagIds[] = [$this->id, $tagId];
        	}
        	Yii::$app->db->createCommand()->batchInsert('TagMaster', ['tagId', 'tagId2'], $tagIds)->execute();
        }
        return true;
    }
    
    public function getCategoryName()
	{
		return Yii::t('frontend', 'Thema');
	}
}
