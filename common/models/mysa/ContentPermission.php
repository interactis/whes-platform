<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ContentPermission".
 *
 * @property integer $id
 * @property string $permissionName
 *
 * @property Story[] $stories
 */
class ContentPermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ContentPermission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['permissionName'], 'required'],
            [['permissionName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'permissionName' => Yii::t('app', 'Permission Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['permission' => 'id']);
    }
}
