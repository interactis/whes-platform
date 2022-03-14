<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "MediaDescription".
 *
 * @property integer $id
 * @property integer $mediaMasterId
 * @property integer $languageId
 * @property string $description
 *
 * @property Language $language
 * @property MediaMaster $mediaMaster
 */
class MediaDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MediaDescription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mediaMasterId', 'languageId', 'description'], 'required'],
            [['mediaMasterId', 'languageId'], 'integer'],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mediaMasterId' => Yii::t('app', 'Media Master ID'),
            'languageId' => Yii::t('app', 'Language ID'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'languageId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaMaster()
    {
        return $this->hasOne(MediaMaster::className(), ['id' => 'mediaMasterId']);
    }
}
