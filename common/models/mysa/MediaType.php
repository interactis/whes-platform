<?php

namespace common\models\mysa;

use Yii;

/**
 * This is the model class for table "MediaType".
 *
 * @property integer $id
 * @property string $typeName
 *
 * @property MediaMaster[] $mediaMasters
 */
class MediaType extends \yii\db\ActiveRecord
{
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}
	
    // Values as imported from original db-dump.
    const IMAGE = 'image';
    const YOUTUBE_VIDEO = 'youTube';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MediaType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typeName'], 'required'],
            [['typeName'], 'string', 'max' => 50],
            ['typeName', 'in', []]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'typeName' => Yii::t('app', 'Type Name'),
        ];
    }

    public function isYoutube()
    {
        return ($this->typeName == self::YOUTUBE_VIDEO) ? true : false;
    }

    public function isImage()
    {
        return ($this->typeName == self::IMAGE) ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaMasters()
    {
        return $this->hasMany(MediaMaster::className(), ['type' => 'id']);
    }
}