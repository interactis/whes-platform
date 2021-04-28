<?php
namespace common\models\helpers;

use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;
use common\models\Tag;
use common\models\ContentTag;


class HelperModel extends TranslationModel
{	
    public $tags = [];
    
    public function getPriorities()
    {
    	return [
			3 => Yii::t('app', 'Low'),
			2 => Yii::t('app', 'Medium'),
			1 => Yii::t('app', 'High'),
		];
    }
    
    public function saveTags()
    {
        ContentTag::deleteAll(['content_id' => $this->content_id]);
    	
		$tagIds = [];
		foreach ($this->tags as $tagId)
		{
			if (is_numeric($tagId))
			{
				if (Tag::findOne($tagId))
					$tagIds[] = [$this->content_id, $tagId];
			}
		}
		Yii::$app->db->createCommand()->batchInsert('content_tag', ['content_id', 'tag_id'], $tagIds)->execute();
        
        return true;
    }
    
    /*
    private function _saveTag($title)
    {
    	$tag = Tag::findOne(['title' => $title]);
    	if (!$tag)
    	{
    		$tag = new Tag();
    		$tag->active = $title;
    		$tag->save();
    		// save tage translations here (title)
    	}
    	return $tag;
    }
    */
    
    public function generateSlugs($field = 'title')
    {
    	$translations = $this->_getTranslationsField();
    	foreach($this->$translations as $translation)
    	{
    		if (empty($translation->slug)) {
				$translation->slug = $this->_generateSlug($translation, $field);
				$translation->save(false);
    		}
    	}
    	
    	return true;
    }
    
    private function _generateSlug($translation, $field, $i = 0)
    {
    	$text = $translation->{$field};
    
    	$slug = $this->_slugify($text) .'-'. $i;
    	if ($i == 0)
    		$slug = $this->_slugify($text);
    	
    	$exists = $this->getTranslationTableName()::find()
    		->where(['slug' => $slug])
    		->andWhere(['!=', 'id', $translation->id])
    		->one();
    	
    	if ($exists)
    	{
    		$i = $i+1;
    		return $this->_generateSlug($translation, $field, $i);
    	}
    	else
    		return $slug;
    }
    
    private function _slugify($text)
	{
		// remove shy hyphens
		$text = str_replace('&shy;', '', $text);
		
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		
		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);
		
		// trim
		$max = 34; // 36 - 2 because of $i
		if (strlen($text) > $max)
			$text = substr($text, 0, $max);
			
		return $text;
	}
	
	private function _getTranslationsField()
    {
    	return $this->tableName() .'Translations';
    }
    
    private function _getRelationIdField()
    {
    	return $this->tableName() .'_id';
    }
    
    private function _ucFirstTableName()
    {
    	return ucfirst($this->tableName());
    }
}
