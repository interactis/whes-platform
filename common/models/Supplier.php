<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\TranslationModel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property int|null $heritage_id
 * @property string|null $street
 * @property string|null $street_number
 * @property string|null $address_addition
 * @property string|null $zip
 * @property string|null $city
 * @property string|null $url
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $geom
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $content
 * @property Heritage $heritage
 * @property SupplierTranslation[] $supplierTranslations
 */
class Supplier extends TranslationModel
{
	public $translationFields = ['name', 'name_affix', 'remarks'];
	public $requiredTranslationFields = ['name'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
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
            [['heritage_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['heritage_id', 'created_at', 'updated_at'], 'integer'],
            [['geom'], 'string'],
            [['street', 'address_addition', 'url', 'email'], 'string', 'max' => 255],
            [['street_number'], 'string', 'max' => 10],
            [['zip'], 'string', 'min' => 4, 'max' => 8],
            [['city'], 'string', 'max' => 150],
            [['phone'], 'string', 'min' => 8, 'max' => 20],
            [['email'], 'email'],
            [['url'], 'url'],
            [['heritage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Heritage::className(), 'targetAttribute' => ['heritage_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'heritage_id' => Yii::t('app', 'Heritage'),
            'street' => Yii::t('app', 'Street'),
            'street_number' => Yii::t('app', 'Street Number'),
            'address_addition' => Yii::t('app', 'Address Addition'),
            'zip' => Yii::t('app', 'Zip'),
            'city' => Yii::t('app', 'City'),
            'url' => Yii::t('app', 'URL'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'geom' => Yii::t('app', 'Geom'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
	
    public function getContents()
    {
        return $this->hasMany(Content::className(), ['supplier_id' => 'id']);
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
    
    public static function getSuppliers()
    {
        $models = Supplier::find()
        	->joinWith('supplierTranslations')
        	->where(['language_id' => Yii::$app->params['preferredLanguageId']])
        	->orderBy(['name' => SORT_ASC])
        	->all();
        	
       return ArrayHelper::map($models, 'id', 'name');
    }
    

    /**
     * Gets query for [[SupplierTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplierTranslations()
    {
        return $this->hasMany(SupplierTranslation::className(), ['supplier_id' => 'id']);
    }
}
