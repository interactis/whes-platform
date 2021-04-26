<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier_translation".
 *
 * @property int $id
 * @property int|null $supplier_id
 * @property int|null $language_id
 * @property string|null $name
 * @property string|null $name_affix
 * @property string|null $remarks
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Language $language
 * @property Supplier $supplier
 */
class SupplierTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['supplier_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['remarks'], 'string'],
            [['name', 'name_affix'], 'string', 'max' => 150],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'supplier_id' => Yii::t('app', 'Supplier ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'name' => Yii::t('app', 'Name'),
            'name_affix' => Yii::t('app', 'Name Affix'),
            'remarks' => Yii::t('app', 'Remarks'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }
}
