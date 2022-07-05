<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\TranslationModel;

/**
 * This is the model class for table "profile_item".
 *
 * @property int $id
 * @property int|null $heritage_id
 * @property int|null $order
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Heritage $heritage
 * @property ProfileItemTranslation[] $profileItemTranslations
 */
class ProfileItem extends TranslationModel
{
	public $translationFields = ['title', 'description'];
	public $requiredTranslationFields = ['title', 'description'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_item';
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
            [['heritage_id', 'order', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['heritage_id', 'order', 'created_at', 'updated_at'], 'integer'],
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
            'heritage_id' => Yii::t('app', 'Heritage ID'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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

    /**
     * Gets query for [[ProfileItemTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileItemTranslations()
    {
        return $this->hasMany(ProfileItemTranslation::className(), ['profile_item_id' => 'id']);
    }
}
