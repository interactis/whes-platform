<?php

namespace common\models;

use Yii;

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
class FlagGroup extends \yii\db\ActiveRecord
{
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
}
