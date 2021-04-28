<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Media[] $media
 * @property PageTranslation[] $pageTranslations
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
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
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['page_id' => 'id'])
        	->orderBy(['order' => SORT_ASC, 'id' => SORT_ASC]);
    }

    /**
     * Gets query for [[PageTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPageTranslations()
    {
        return $this->hasMany(PageTranslation::className(), ['page_id' => 'id']);
    }
}
