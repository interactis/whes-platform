<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\TranslationModel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "flag".
 *
 * @property int $id
 * @property int|null $flag_group_id
 * @property bool|null $label
 * @property bool|null $operator
 * @property bool|null $visitor
 * @property bool|null $edu
 * @property bool|null $eut
 * @property bool|null $hidden
 * @property int|null $order
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property ContentFlag[] $contentFlags
 * @property FlagGroup $flagGroup
 * @property FlagTranslation[] $flagTranslations
 */
class Flag extends TranslationModel
{
	public $translationFields = ['title', 'disclaimer'];
	public $requiredTranslationFields = ['title'];
	public $operators = [
		'or' => 'OR',
		'and' => 'AND'
	];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flag';
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
            [['flag_group_id', 'order', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['flag_group_id', 'order', 'created_at', 'updated_at'], 'integer'],
            [['visitor', 'edu', 'eut', 'hidden', 'label'], 'boolean'],
            [['flag_group_id', 'operator'], 'required'],
            [['flag_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlagGroup::className(), 'targetAttribute' => ['flag_group_id' => 'id']],
            ['operator', 'string', 'max' => 6]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'flag_group_id' => Yii::t('app', 'Flag Group'),
            'label' => Yii::t('app', 'Label'),
            'operator' => Yii::t('app', 'Operator'),
            'visitor' => Yii::t('app', 'Visitor'),
            'edu' => Yii::t('app', 'EDU'),
            'eut' => Yii::t('app', 'Eiger Ultra Trail'),
            'hidden' => Yii::t('app', 'Hidden'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ContentFlags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContentFlags()
    {
        return $this->hasMany(ContentFlag::className(), ['flag_id' => 'id']);
    }

    /**
     * Gets query for [[FlagGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlagGroup()
    {
        return $this->hasOne(FlagGroup::className(), ['id' => 'flag_group_id']);
    }

    /**
     * Gets query for [[FlagTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlagTranslations()
    {
        return $this->hasMany(FlagTranslation::className(), ['flag_id' => 'id']);
    }
    
    public static function getFlagList($type = false)
    {
    	$models = Flag::find()
    		->joinWith('flagTranslations');
    	
    	if ($type)
    	{
    		$models->where([
        		$type => true		
        	]);
    	}
    	
    	$models = $models->orderBy('title')->all();
    		
        return ArrayHelper::map($models, 'id', 'title');
    }
}
