<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 *
 * @property ArticleTranslation[] $articleTranslations
 * @property FlagGroupTranslation[] $flagGroupTranslations
 * @property FlagTranslation[] $flagTranslations
 * @property HeritageTranslation[] $heritageTranslations
 * @property MediaTranslation[] $mediaTranslations
 * @property PoiTranslation[] $poiTranslations
 * @property RouteTranslation[] $routeTranslations
 * @property SupplierTranslation[] $supplierTranslations
 * @property TagTranslation[] $tagTranslations
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[ArticleTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTranslations()
    {
        return $this->hasMany(ArticleTranslation::className(), ['language_id' => 'id']);
    }

    /**
     * Gets query for [[FlagGroupTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlagGroupTranslations()
    {
        return $this->hasMany(FlagGroupTranslation::className(), ['language_id' => 'id']);
    }

    /**
     * Gets query for [[FlagTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlagTranslations()
    {
        return $this->hasMany(FlagTranslation::className(), ['language_id' => 'id']);
    }

    /**
     * Gets query for [[HeritageTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeritageTranslations()
    {
        return $this->hasMany(HeritageTranslation::className(), ['language_id' => 'id']);
    }

    /**
     * Gets query for [[MediaTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMediaTranslations()
    {
        return $this->hasMany(MediaTranslation::className(), ['language_id' => 'id']);
    }

    /**
     * Gets query for [[PoiTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoiTranslations()
    {
        return $this->hasMany(PoiTranslation::className(), ['language_id' => 'id']);
    }

    /**
     * Gets query for [[RouteTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRouteTranslations()
    {
        return $this->hasMany(RouteTranslation::className(), ['language_id' => 'id']);
    }

    /**
     * Gets query for [[SupplierTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplierTranslations()
    {
        return $this->hasMany(SupplierTranslation::className(), ['language_id' => 'id']);
    }

    /**
     * Gets query for [[TagTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagTranslations()
    {
        return $this->hasMany(TagTranslation::className(), ['language_id' => 'id']);
    }
    
    public static function getLanguages()
    {
        $languages = Language::find()->all();
        return ArrayHelper::map($languages, 'code', 'id');
    }
}
