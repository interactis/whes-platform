<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "route_translation".
 *
 * @property int $id
 * @property int|null $route_id
 * @property int|null $language_id
 * @property string|null $slug
 * @property string|null $title
 * @property string|null $description
 * @property string|null $youtube_id
 * @property string|null $catering
 * @property string|null $options
 * @property string|null $remarks
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Language $language
 * @property Route $route
 */
class RouteTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route_translation';
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
            [['route_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['route_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'catering', 'options', 'remarks'], 'string'],
            [['slug', 'title', 'youtube_id'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['route_id'], 'exist', 'skipOnError' => true, 'targetClass' => Route::className(), 'targetAttribute' => ['route_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'route_id' => Yii::t('app', 'Route ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'youtube_id' => Yii::t('app', 'YouTube ID'),
            'catering' => Yii::t('app', 'Restaurants / Catering Options'),
            'options' => Yii::t('app', 'Route Options'),
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
     * Gets query for [[Route]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoute()
    {
        return $this->hasOne(Route::className(), ['id' => 'route_id']);
    }
}
