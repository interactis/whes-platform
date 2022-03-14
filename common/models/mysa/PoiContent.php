<?php

namespace common\models;

use Yii;
use common\components\validators\DefaultLanguageValidator;
use common\components\validators\RegisterAvailableTranslationsValidator;
use common\components\validators\TranslationsValidator;

/**
 * This is the model class for table "PoiContent".
 *
 * @property integer $id
 * @property integer $poiId
 * @property integer $languageId
 * @property string $title
 * @property string $description
 * @property string $supplierName
 * @property string $supplierNameAffix
 * @property string $supplierRemark
 * @property string $directions
 * @property string $ambassadorFirstName
 * @property string $ambassadorLastName
 * @property string $ambassadorPlace
 * @property string $ambassadorQuote
 *
 * @property Language $language
 * @property Poi $poi
 */
class PoiContent extends \yii\db\ActiveRecord
{
	
	// Default values:
	public $ambassadorFirstName = "";
	public $ambassadorLastName = "";
	public $ambassadorPlace = "";
	public $ambassadorQuote = "";
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PoiContent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languageId'], 'required'],
            [['poiId', 'languageId'], 'integer'],
            [['title', 'description', 'directions', 'ambassadorQuote'], 'string'],
            [['supplierName', 'supplierNameAffix', 'ambassadorFirstName', 'ambassadorFirstName'], 'string', 'max' => 150],
            [['supplierRemark', 'ambassadorPlace'], 'string', 'max' => 255],
            [['title', 'description'], DefaultLanguageValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
           	[['title', 'description', 'supplierName', 'supplierNameAffix', 'supplierRemark', 'directions'], RegisterAvailableTranslationsValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
           	[['title', 'description', 'supplierName', 'supplierNameAffix', 'supplierRemark', 'directions'], TranslationsValidator::className(), 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'poiId' => Yii::t('app', 'Poi ID'),
            'languageId' => Yii::t('app', 'Language ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'supplierName' => Yii::t('app', 'Supplier Name'),
            'supplierNameAffix' => Yii::t('app', 'Supplier Name Affix'),
            'supplierRemark' => Yii::t('app', 'Supplier Remark'),
            'directions' => Yii::t('app', 'Directions (Optional Description)'),
            'ambassadorFirstName' => Yii::t('app', 'Ambassador First Name'),
            'ambassadorLastName' => Yii::t('app', 'Ambassador Last Name'),
            'ambassadorPlace' => Yii::t('app', 'Ambassador Place'),
            'ambassadorQuote' => Yii::t('app', 'Ambassador Quote'),
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
    public function getPoi()
    {
        return $this->hasOne(Poi::className(), ['id' => 'poiId']);
    }
}
