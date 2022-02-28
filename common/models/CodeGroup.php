<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "code_group".
 *
 * @property int $id
 * @property int|null $heritage_id
 * @property string|null $title
 * @property int|null $code_count
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Code[] $codes
 * @property Heritage $heritage
 */
class CodeGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'code_group';
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
            [['heritage_id', 'code_series_id', 'code_count', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['heritage_id', 'code_series_id', 'code_count', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['heritage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Heritage::className(), 'targetAttribute' => ['heritage_id' => 'id']],
        	[['code_series_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodeSeries::className(), 'targetAttribute' => ['code_series_id' => 'id']],
        	[['heritage_id', 'code_series_id', 'code_count', 'title'], 'required'],
            ['code_count', 'compare', 'compareValue' => 0, 'operator' => '>'],
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
            'code_series_id' => Yii::t('app', 'Code Series ID'),
            'title' => Yii::t('app', 'Title'),
            'code_count' => Yii::t('app', 'Number of Codes'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Codes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodes()
    {
        return $this->hasMany(Code::className(), ['code_group_id' => 'id']);
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
}
