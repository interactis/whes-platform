<?php

namespace common\models\mysa;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "Story".
 *
 * @property integer $id
 * @property string $authorName
 * @property string $authorUrl
 * @property integer $status
 * @property string $creationTime
 * @property integer $permaId
 * @property string $videoIds
 *
 * @property MediaMaster[] $mediaMasters
 * @property ContentStatus $status0
 * @property StoryContent[] $storyContents
 * @property TagMaster[] $tagMasters
 * @property ValidTimeMaster[] $validTimeMasters
 */
class Story extends TranslatedModel
{
	public $validTimes = [];
	public $relatedTags = [];
	public $images = [];
	
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Story';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'authorName', 'relatedTags', 'validTimes'], 'required'],
            [['status', 'permaId'], 'integer'],
            [['creationTime'], 'safe'],
            [['authorName'], 'string', 'max' => 150],
            [['authorUrl'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'authorName' => Yii::t('app', 'Author Name'),
            'authorUrl' => Yii::t('app', 'Author Url'),
            'status' => Yii::t('app', 'Status'),
            'creationTime' => Yii::t('app', 'Creation Time'),
            'permaId' => Yii::t('app', 'Perma ID'),
            'videoIds' => Yii::t('app', 'Videos'),
            // labels for the backend grid
            'title' => Yii::t('app', 'Title'),
            'tags' => Yii::t('app', 'Tags'),
            'languages'=>Yii::t('app', 'Languages'),
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
        return $this->hasMany(MediaMaster::className(), ['storyId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    private function _getMediaType($typeName)
    {
        return $this->getMediaMasters()->leftJoin('MediaType', '"MediaMaster".type="MediaType".id')
            ->andWhere(['MediaType.typeName' => $typeName]);
    }
	*/
	
    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getMediaImages()
    {
        return $this->_getMediaType(MediaType::IMAGE);
    }
	*/
	
    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getMediaVideos()
    {
        return $this->_getMediaType(MediaType::YOUTUBE_VIDEO);
    }
	*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ContentStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoryContents()
    {
        return $this->hasMany(StoryContent::className(), ['storyId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagMasters()
    {
        return $this->hasMany(TagMaster::className(), ['storyId' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidTimeMasters()
    {
        return $this->hasMany(ValidTimeMaster::className(), ['storyId' => 'id']);
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
     */
    public function saveRelatedTags($post)
    {
        // It's easier to just batch delete and insert instead of calculating the diff first,
        // as we receive a complete list of tag ids anyhow.
        TagMaster::deleteAll(['storyId' => $this->id]);
        
        if (isset($post['Story']['relatedTags']))
        {
        	// This command expects values in the form of ['tagId', 'tagId2'], so we rebuild the array.
        	$tagIds = [];
        	foreach ($post['Story']['relatedTags'] as $tagId)
        	{
        		// Avoid self-relations
        		if ($this->id != $tagId)
        			$tagIds[] = [$this->id, $tagId];
        	}
        	Yii::$app->db->createCommand()->batchInsert('TagMaster', ['storyId', 'tagId'], $tagIds)->execute();
        }
        return true;
    }
    
    public function saveRelatedValidTimes($post)
    {
        ValidTimeMaster::deleteAll(['storyId' => $this->id]);
        
        if (isset($post['Story']['validTimes']))
        {
        	$validTimeIds = [];
        	foreach ($post['Story']['validTimes'] as $validTimeId)
        	{
				$validTimeIds[] = [$this->id, $validTimeId];
        	}
        	Yii::$app->db->createCommand()->batchInsert('ValidTimeMaster', ['storyId', 'validTimeId'], $validTimeIds)->execute();
        }
        return true;
    }
    
    public function getCategoryName()
	{
		return Yii::t('frontend', 'Wissenswertes');
	}
}
