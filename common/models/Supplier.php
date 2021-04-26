<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property int|null $content_id
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
 * @property SupplierTranslation[] $supplierTranslations
 */
class Supplier extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['content_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'created_at', 'updated_at'], 'integer'],
            [['geom'], 'string'],
            [['street', 'address_addition', 'url', 'email'], 'string', 'max' => 255],
            [['street_number', 'zip'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 50],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'street' => Yii::t('app', 'Street'),
            'street_number' => Yii::t('app', 'Street Number'),
            'address_addition' => Yii::t('app', 'Address Addition'),
            'zip' => Yii::t('app', 'Zip'),
            'city' => Yii::t('app', 'City'),
            'url' => Yii::t('app', 'Url'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'geom' => Yii::t('app', 'Geom'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Content]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
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
