<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\TranslationModel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "flag_group".
 *
 * @property int $id
 * @property int|null $order
 * @property bool|null $hidden
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Flag[] $flags
 * @property FlagGroupTranslation[] $flagGroupTranslations
 */
class FlagGroup extends TranslationModel
{
	public $translationFields = ['title'];
	public $requiredTranslationFields = ['title'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flag_group';
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
            [['order', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['order', 'created_at', 'updated_at'], 'integer'],
            [['hidden'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order' => Yii::t('app', 'Order'),
            'hidden' => Yii::t('app', 'Hidden'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Flags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlags()
    {
        return $this->hasMany(Flag::className(), ['flag_group_id' => 'id']);
    }

    /**
     * Gets query for [[FlagGroupTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlagGroupTranslations()
    {
        return $this->hasMany(FlagGroupTranslation::className(), ['flag_group_id' => 'id']);
    }
    
    public static function getFlagGroups()
    {
        $models = FlagGroup::find()
        	->joinWith('flagGroupTranslations')
        	->where(['language_id' => Yii::$app->params['preferredLanguageId']])
        	->orderBy(['title' => SORT_ASC])
        	->all();
        return ArrayHelper::map($models, 'id', 'title');
    }
}
