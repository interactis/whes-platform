<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "code_series".
 *
 * @property int $id
 * @property int|null $code_count
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Code[] $codes
 */
class CodeSeries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'code_series';
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
            [['code_count', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['code_count', 'created_at', 'updated_at'], 'integer'],
            ['code_count', 'required'],
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
            'code_count' => Yii::t('app', 'Number of Codes'),
            'created_at' => Yii::t('app', 'Creation Time'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * Gets query for [[Codes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodes()
    {
        return $this->hasMany(Code::className(), ['code_series_id' => 'id']);
    }
    
    public function createCodes()
	{
		for ($i = 0; $i < $this->code_count; $i++)
		{
    		$code = $this->_generateUniqueCode();
    		$model = new Code();
    		$model->code_series_id = $this->id;
    		$model->code = $code;
    		$model->type = 1; // default = info
    		$model->save();
		}
		return true;
	}
	
	private function _generateUniqueCode()
	{
    	$code = $this->_generateRandomString();
    	$model = Code::find()->where(['code' => $code])->one();
    	
    	if ($model)
    	{
    		// generate another code if already existing
    		return $this->_generateUniqueCode();
    	}
    	else
    		return $code;
    }
    
    private function _generateRandomString($length = 4)
    {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++)
    	{
    	    $randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
	    return $randomString;
	}
	
	/*
	HIER WEITERMACHEN
	private function _saveCsv($codes, $seriesId)
	{
		$fp = fopen('console/exhibitionCodes/Exhibition-Codes-Series-'. $seriesId .'.csv', 'w');
		foreach ($codes as $fields) {
    		fputcsv($fp, $fields);
		}
		fclose($fp);
	}
	*/
}
