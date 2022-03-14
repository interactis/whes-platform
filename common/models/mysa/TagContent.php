<?php

namespace common\models\mysa;

use Yii;
use common\components\validators\DefaultLanguageValidator;
use common\components\validators\RegisterAvailableTranslationsValidator;
use common\components\validators\TranslationsValidator;

/**
 * This is the model class for table "TagContent".
 *
 * @property integer $id
 * @property integer $tagId
 * @property integer $languageId
 * @property string $name
 * @property string $description
 *
 * @property Language $language
 * @property Tag $tag
 */
class TagContent extends \yii\db\ActiveRecord
{
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TagContent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languageId'], 'required'],
            [['tagId', 'languageId'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'uniqueNameValidation'],
            [['description'], 'featuredValidation', 'skipOnEmpty' => false, 'skipOnError' => false],
            [['name'], DefaultLanguageValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
           	[['name', 'description'], RegisterAvailableTranslationsValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
           	[['name', 'description'], 'translationsValidation', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }
    
    public function uniqueNameValidation($attribute, $params)
    {
		$query = TagContent::find()
			->andFilterWhere([
			'lower(name)' => strtolower($this->name),
			'"languageId"' => $this->languageId,
		]);
		
		if (!$this->isNewRecord)
			$query->andWhere('id!='. $this->id);
		
		$exists = $query->exists();
	
		if ($exists)
		{
			$languages = array_flip(call_user_func(Yii::$app->params['languageCodes']));
			$this->addError($attribute, $this->getAttributeLabel($attribute) .' '. strtoupper($languages[$this->languageId]) .' "'. $this->$attribute .'" has already been taken.');
		}
    }
    
    public function featuredValidation($attribute, $params)
    {
    	if ($_POST["Tag"]["featured"] && $this->languageId == Yii::$app->params['defaultLanguageId'] && empty($this->description))
        {
    		$languages = array_flip(call_user_func(Yii::$app->params['languageCodes']));
    		$this->addError($attribute, ucfirst($attribute) ." ". strtoupper($languages[$this->languageId]) .' cannot be blank.');
    	}		
    }
    
    public function translationsValidation($attribute, $params)
    {
    	// all translation fields must be set if one field has been translated
    	if ($this->languageId != Yii::$app->params['defaultLanguageId'] && in_array($attribute,  Yii::$app->controller->requiredTranslationFields) && in_array($this->languageId, Yii::$app->controller->availableTranslations) && empty($this->$attribute))
    	{	
    		if ($_POST["Tag"]["featured"])
    		{
    			$this->_addError($attribute);
    		}
    	}
    }

	private function _addError($attribute)
	{
		$languages = array_flip(call_user_func(Yii::$app->params['languageCodes']));
    	$this->addError($attribute, ucfirst($attribute) ." ". strtoupper($languages[$this->languageId]) .' cannot be blank.');
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tagId' => Yii::t('app', 'Tag ID'),
            'languageId' => Yii::t('app', 'Language ID'),
            'name' => Yii::t('app', 'Tag Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'languageId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tagId']);
    }
}