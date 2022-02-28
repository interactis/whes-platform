<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\TranslationModel;

/**
 * This is the model class for table "code".
 *
 * @property int $id
 * @property int|null $code_series_id
 * @property int|null $code_group_id
 * @property int|null $content_id
 * @property int|null $type
 * @property string $code
 * @property bool|null $active
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property CodeGroup $codeGroup
 * @property CodeSeries $codeSeries
 * @property Content $content
 * @property CodeTranslation[] $codeTranslations
 */
class Code extends TranslationModel
{
	public $translationFields = ['info'];
	public $requiredTranslationFields = [];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'code';
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
            [['code_series_id', 'code_group_id', 'content_id', 'type', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['code_series_id', 'code_group_id', 'content_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['code'], 'required'],
            [['active'], 'boolean'],
            [['code'], 'string', 'max' => 6],
            [['code'], 'unique'],
            [['code_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodeGroup::className(), 'targetAttribute' => ['code_group_id' => 'id']],
            [['code_series_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodeSeries::className(), 'targetAttribute' => ['code_series_id' => 'id']],
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
            'code_series_id' => Yii::t('app', 'Code Series ID'),
            'code_group_id' => Yii::t('app', 'Code Group'),
            'content_id' => Yii::t('app', 'Content'),
            'type' => Yii::t('app', 'Type'),
            'code' => Yii::t('app', 'Code'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[CodeGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodeGroup()
    {
        return $this->hasOne(CodeGroup::className(), ['id' => 'code_group_id']);
    }

    /**
     * Gets query for [[CodeSeries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodeSeries()
    {
        return $this->hasOne(CodeSeries::className(), ['id' => 'code_series_id']);
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
     * Gets query for [[CodeTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodeTranslations()
    {
        return $this->hasMany(CodeTranslation::className(), ['code_id' => 'id']);
    }
}
