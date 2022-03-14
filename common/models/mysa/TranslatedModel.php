<?php
namespace common\models\mysa;

use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\Html;

/**
 * Class TranslatedModel
 * @package common\models
 *
 * Helper model which queries translated content and adds it to the object if called.
 * Override the contentTableName or joinField if the join does not follow the pattern:
 * join <tableName>Content on id = <tableName>Content.<tableName>Id
 *
 */
class TranslatedModel extends \yii\db\ActiveRecord
{
    public $contentTableName = '';
    public $joinFieldName = '';
    
    public static function getDb()
	{
		return Yii::$app->dbMysa;
	}

    /**
     * @return string
     * Table to query for translations; Defaults to <tableName>Content.
     */
    public function getContentTableName()
    {
        return ($this->contentTableName) ? $this->contentTableName : self::className().'Content';
    }

    /**
     * @return string <table>Content without module path.
     */
    public function getTableContentNameOnly()
    {
    	$nameArray = explode("\\", $this->getContentTableName());
        return end($nameArray);
    }

    /**
     * @return string
     * Field to make the join for the translations on; Defaults to <tableName>Id.
     */
    public function getJoinField()
    {
        return ($this->joinFieldName) ? $this->joinFieldName : lcfirst($this->tableName()).'Id';
    }

    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $exception) {
            $translatedField = $this->getTranslatedField($name, Yii::$app->params['preferredLanguageId']);
            // After discussion with Dominik: Return fallback language and prepend an info-box.
            if (!$translatedField) {
                $fallbackField = $this->getTranslatedField($name, Yii::$app->params['defaultLanguageId']);
                if ($fallbackField) {
                    return $fallbackField->$name;
                } else {
                    return '';
                }
            }
            return $translatedField->$name;
        }
    }


    public function getTranslatedField($name, $languageId)
    {
        // @maybe: query all fields on the content-table and cache the result.
        return call_user_func($this->getContentTableName().'::findOne',
            ['"'.$this->getJoinField().'"' => $this->id, 'languageId' => $languageId]
        );
    }

    /**
     * @return array
     * Return an array with fields of the translation-model.
     */
    public function getTranslatedFieldAttributes()
    {
        return call_user_func($this->getContentTableName().'::attributes');
    }
	
	/**
     * @param $post array
     * @param $translatedFields array
     * @return bool
     */
    public function validateTranslations($post, $translatedFields, $model)
    {
        return $this->saveTranslations($post, $translatedFields, $model, false);
    }
    
    /**
     * @param $post array
     * @param $translatedFields array
     * @return bool
     */
    public function saveTranslations($post, $translatedFields, $model, $save = true)
    {
        // check if translated content is available.
        if (!isset($post[$this->getTableContentNameOnly()])) {
            return false;
        }
        $translatedContents = $post[$this->getTableContentNameOnly()];
        // the array key is always the languageId of the translated content.
        foreach ($translatedContents as $languageId => $content)
        {
        	$field = call_user_func($this->getContentTableName().'::findOne',
                ['"'.$this->getJoinField().'"' => $this->id, 'languageId' => $languageId]
            );
            
        	if (!$this->_translationIsEmpty($translatedFields, $content))
        	{
        		// create new field if it doesn't exist.
            	if (!$field)
            	{
            	    $className = $this->getContentTableName();
            	    $field = new $className;
            	    $field->languageId = $languageId;
            	    $joinField = $this->getJoinField();
            	    $field->$joinField = $this->id;
            	}
            	// update with values from the POST
            	foreach ($translatedFields as $translatedFieldName) {
            	    $field->$translatedFieldName = $content[$translatedFieldName];
            	}

            	// break out of the loop if data is invalid; raise the error appropriately.
            	if ($field->validate())
				{
					if ($save)
						$field->save();
				}
				else
				{
					$model->addErrors($field->errors);
					return false;
				}
			}
			else
			{
				// delete existing translation fields if translation is empty
				if ($field)
            	{
            		call_user_func($this->getContentTableName().'::deleteAll',
            			['"'. $this->getJoinField() .'"' => $this->id, 'languageId' => $languageId]
            		);
				}
			}
        }
        return true;
    }
    
    private function _translationIsEmpty($translatedFields, $content)
    {
    	$isEmpty = true;
    	foreach ($translatedFields as $translatedFieldName)
    	{
        	if (!empty($content[$translatedFieldName]))
        		$isEmpty = false;
        }
        return $isEmpty;
    }
    
     /**
     * @param $post array
     * @return bool
     */
    public function saveRelatedImages($post)
    {
    	// don't uncomment the line below in production.
    	// change memory_limit in php.ini file instead.
    	// ini_set('memory_limit', '-1');
    	
    	$tableName = $this->tableName();
    	$idField = strtolower($tableName) .'Id';
    	$imgPath = Yii::getAlias('@frontend/web/img/crop/'. \Yii::$app->params['imageFormats'][0]["width"]);
    	
    	// It's easier to just batch delete and insert instead of calculating the diff first
        MediaMaster::deleteAll([$idField => $this->id]);
        
        if (isset($post[$tableName]['images']))
        {
        	foreach ($post[$tableName]['images'] as $image)
        	{
        		if ($image['mediaId'] != '{{mediaId}}') // if not template code
        		{
					$mediaMaster = new mediaMaster();
					$mediaMaster->mediaId = $image['mediaId'];
					$mediaMaster->$idField = $this->id;
					
					$mediaMaster->save();
				
					foreach ($image['description'] as $languageId => $description)
        			{
						$mediaDescription = new MediaDescription();
						$mediaDescription->mediaMasterId = $mediaMaster->id;
						$mediaDescription->languageId = $languageId;
						$mediaDescription->description = $description;
						$mediaDescription->save();
					}
        		}
        	}
        }
        return true;
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->isNewRecord)
            {
                $this->creationTime = new \yii\db\Expression('NOW()');
            }
            return true;
        }
    }
}
