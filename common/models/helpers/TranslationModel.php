<?php

namespace common\models\helpers;

use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 *
 * Helper model which queries translations and adds it to the object if called.
 *
 */
class TranslationModel extends ImageModel
{	
	private $_mediaSet = [];
	
	public $availableLanguages = [];
	public $availableInOneLanguageAtLeast = [];
	public $availableByLanguage = [];
	public $hyphenFields = [];
	
	public function __get($name)
    {
        try
        {
        	return parent::__get($name);
        }
        catch (UnknownPropertyException $exception)
        {
            $translatedField = $this->getTranslatedField(Yii::$app->params['preferredLanguageId']);
            
            // Return fallback language if not translated
            if (!$translatedField)
            {
                $fallbackField = $this->getTranslatedField(Yii::$app->params['secondaryLanguageId']);
                if ($fallbackField)
                {
                    return $fallbackField->$name;
                }
                else
                    return '';
            }
            return $translatedField->$name;
        }
    }

    public function getTranslatedField($languageId)
    {
    	$field = $this->getTranslationTableName()::find()
            ->where([
            	$this->getJoinField() => $this->id,
            	'language_id' => $languageId
            ])
            ->one();
        
        return $field;
    }

    /**
     * @return array
     * Return an array with fields of the translation-model
     */
    /*
    public function getTranslatedFieldAttributes()
    {
        return call_user_func($this->getTranslationTableName().'::attributes');
    }
    */
	
    /**
     * @return string
     * Table to query for translations; Defaults to <tableName>Translation
     */
    public function getTranslationTableName()
    {
        return self::className().'Translation';
    }

    /**
     * @return string <tableName>Translation without module path
     */
    public function getTranslationTableNameOnly()
    {
    	$nameSpace = explode("\\", $this->getTranslationTableName());
        return end($nameSpace);
    }

    /**
     * @return string
     * Field to make the join for the translations on; Defaults to <tableName>_id.
     */
    public function getJoinField()
    {
        return lcfirst($this->tableName()).'_id';
    }
	
	/**
     * @param $post array
     * @return bool
     */
    public function validateTranslations($post, $index = false)
    {    
    	if ($index !== false)
    	{
    		$postFields = $post[$this->getTranslationTableNameOnly()][$index];
    	}
    	else
    		$postFields = $post[$this->getTranslationTableNameOnly()];
    	
    	// check if translated content is available.
        if (!isset($postFields))
            return false;
        
        // loop through the posted data and set the available languages
    	foreach ($postFields as $languageId => $content)
        {
        	$this->availableByLanguage[$languageId] = [];
        	
        	foreach ($this->translationFields as $field)
        	{
        		if (!empty($content[$field]))
        			$this->_setAvailableLanguages($languageId, $field);
        	}
        }
        
        // validate file input
        /*
        if (isset($this->file_field) && !empty($this->file_field))
        {
        	foreach ($this->availableLanguages as $languageId)
        	{
        		$this->_validateFileInput($languageId);
        	}
        }
        */
        
    	$className = $this->getTranslationTableName();
        $translationClass = new $className;
    	
    	// check required fields
    	foreach ($this->requiredTranslationFields as $field)
        {
        	if (!in_array($field, $this->availableInOneLanguageAtLeast))
        	{
        		$this->addError($field, $translationClass->getAttributeLabel($field) .' cannot be blank.');
        		return false;
        	}
        }
        
        // if available in one language, the field should also be available in all other available languages
        /*
        foreach ($this->availableInOneLanguageAtLeast as $field)
        {
        	foreach ($this->availableLanguages as $languageId)
        	{	
        		if (!in_array($field, $this->availableByLanguage[$languageId]))
        		{
        			$this->addError($field, $translationClass->getAttributeLabel($field) .': All languages must be set.');
        			return false;
        		}
        	}
        }
        */
        
        // apply individual field validation rules (defined in model)
    	return $this->saveTranslations($post, false, $index);
    }
    
    private function _setAvailableLanguages($languageId, $field)
    {
    	// set availableLanguages
        if (!in_array($languageId, $this->availableLanguages))
        	$this->availableLanguages[] = $languageId;
        			
        // set all fields that are available in one language at least
        if (!in_array($field, $this->availableInOneLanguageAtLeast))
        	$this->availableInOneLanguageAtLeast[] = $field;
        		    
        // set all fields that are available in each language
        if (!in_array($field, $this->availableByLanguage[$languageId]))
        	$this->availableByLanguage[$languageId][] = $field;	
    }
    
    private function _validateFileInput($languageId)
    {
		if (isset($this->file_field) && !empty($this->file_field))
		{   
			$instance = "[". $languageId ."]". $this->file_field;
			$field = $this->getTranslatedField($languageId);			
			$file = UploadedFile::getInstance($field, $instance);
    		
			if (!empty($file))
			{
				$this->_setAvailableLanguages($languageId, $this->file_field);
			}
		}
    }
    
    /**
     * @param $post array
     * @param $save boolean (if false: Only apply validation without saving)
     * @return bool
     */
    public function saveTranslations($post, $save = true, $index = false)
    {    
    	if ($index !== false) {
    		$postFields = $post[$this->getTranslationTableNameOnly()][$index];
    	}
    	else
    	{
    		$postFields = $post[$this->getTranslationTableNameOnly()];
    	}
    		
        // the array key is always the languageId of the translated content
        foreach ($postFields as $languageId => $content)
        {
            $field = $this->getTranslatedField($languageId);
              
        	if (!$this->_translationIsEmpty($content))
        	{
        		// create new field if it doesn't exist.
            	if (!$field)
            	{
            	    $className = $this->getTranslationTableName();
            	    $field = new $className;
            	    $field->language_id = $languageId;
            	    $joinField = $this->getJoinField();
            	    $field->$joinField = $this->id;
            	}
            	
            	// update with values from the POST
            	foreach ($this->translationFields as $translationFieldName)
            	{
            		$field->$translationFieldName = $content[$translationFieldName];
            		
            		if (in_array($translationFieldName, $this->hyphenFields))
            		{
            			$field->$translationFieldName = str_replace('|', '&shy;', $content[$translationFieldName]);
            		}
            		else
            		{
            			$field->$translationFieldName = $content[$translationFieldName];
            		}
            	}
            	
				// save media files
            	if (isset($this->file_field) && !empty($this->file_field))
            	{   
					$instance = "[". $languageId ."]". $this->file_field;
					$media = $this->saveFile($field, $instance, $languageId);
					$field->file_name = $media['fileName'];
				}
				
            	// break out of the loop if data is invalid; raise the error appropriately.
            	if ($field->validate())
				{
					if ($save)
						$field->save();
				}
				else
				{
					$this->addErrors($field->errors);
					return false;
				}
			}
			else
			{
				// delete existing translation fields if translation is empty
				if ($field && $save)
            	{
            		$field->delete();
				}
			}
        }
        return true;
    }
    
    private function _translationIsEmpty($content)
    {
    	$isEmpty = true;
    	foreach ($this->translationFields as $translationFieldName)
    	{
        	if (!empty($content[$translationFieldName]))
        		$isEmpty = false;
        }
        return $isEmpty;
    }
    
    public function saveFile($field, $instance, $languageId)
    {	
    	$fileName = "";
    	if (!isset($this->_mediaSet[$instance])) // avoid parsing of Yii's hidden file input field
    	{
    		$file = UploadedFile::getInstance($field, $instance);
    		
    		if (!empty($file))
    		{    		
    			$lang = Yii::$app->params['supportedLanguages'][$languageId-1];
    			
    			// delete old file
    			if (!empty($field->file_name))
    			{
    				$oldPath = Yii::getAlias('@frontend/web/file/'. strtolower($this->tableName()) .'/'. $lang .'/'. $field->file_name);
    				if (file_exists($oldPath))
    					unlink($oldPath);
    			}
    			
    			// save new file
    			$fileName = $this->createFileName($file, $lang);
    			$path = Yii::getAlias('@frontend/web/file/'. strtolower($this->tableName()) .'/'. $lang .'/'. $fileName);
    			$file->saveAs($path);
    			
    			$this->_mediaSet[$instance] = ['fileName' => $fileName];
			}
			else
			{
				$fileName = $field->file_name;
			}
		}
		else
		{
			$fileName = $this->_mediaSet[$instance]['fileName'];
		}
		
		return ['fileName' => $fileName];
    }
    
    protected function createFileName($file, $lang, $i = 1)
    {
    	if ($i > 1)
    	{
    		$fileName = $i .'-'. str_replace(' ', '-', $file->name);
    	}
    	else
    		$fileName = str_replace(' ', '-', $file->name);
    	
    	if (file_exists(Yii::getAlias('@frontend/web/file/'. strtolower($this->tableName()) .'/'. $lang .'/'. $fileName)))
    	{
    		return $this->createFileName($file, $lang, $i+1);
    	}
    	else
    		return $fileName;
    }
}
