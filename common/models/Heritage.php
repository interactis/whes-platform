<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "heritage".
 *
 * @property int $id
 * @property string|null $geom
 * @property int|null $priority
 * @property bool|null $published
 * @property bool|null $hidden
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Admin[] $admins
 * @property AmbassadorTranslation[] $ambassadorTranslations
 * @property Content[] $contents
 * @property ExhibitionCodeSeries[] $exhibitionCodeSeries
 * @property HeritageTranslation[] $heritageTranslations
 * @property Media[] $media
 */
class Heritage extends HelperModel
{
	public $translationFields = ['name', 'short_name', 'description', 'link_url', 'link_text'];
	public $requiredTranslationFields = ['name', 'short_name', 'description'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'heritage';
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
            [['geom'], 'string'],
            [['priority', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['priority', 'created_at', 'updated_at'], 'integer'],
            [['published', 'hidden'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'geom' => Yii::t('app', 'Geom'),
            'priority' => Yii::t('app', 'Priority'),
            'published' => Yii::t('app', 'Published'),
            'hidden' => Yii::t('app', 'Hidden'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Admins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmins()
    {
        return $this->hasMany(Admin::className(), ['heritage_id' => 'id']);
    }

    /**
     * Gets query for [[AmbassadorTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAmbassadorTranslations()
    {
        return $this->hasMany(AmbassadorTranslation::className(), ['heritage_id' => 'id']);
    }

    /**
     * Gets query for [[Contents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::className(), ['heritage_id' => 'id']);
    }

    /**
     * Gets query for [[ExhibitionCodeSeries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionCodeSeries()
    {
        return $this->hasMany(ExhibitionCodeSeries::className(), ['heritage_id' => 'id']);
    }

    /**
     * Gets query for [[HeritageTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeritageTranslations()
    {
        return $this->hasMany(HeritageTranslation::className(), ['heritage_id' => 'id']);
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['heritage_id' => 'id'])
        	->orderBy(['order' => SORT_ASC, 'id' => SORT_ASC]);
    }
    
    public static function getHeritages()
    {
        $models = Heritage::find()
        	->joinWith('heritageTranslations')
        	->where(['language_id' => Yii::$app->params['preferredLanguageId']])
        	->orderBy(['short_name' => SORT_ASC])
        	->all();
        return ArrayHelper::map($models, 'id', 'short_name');
    }
    
    public static function getActiveHeritages()
    {
        return Heritage::find()
        	->joinWith('heritageTranslations')
        	->where([
        		'language_id' => Yii::$app->params['preferredLanguageId'],
        		'published'=> true,
        		'hidden' => false
        	])
        	->orderBy(['short_name' => SORT_ASC])
        	->all();
    }
}
