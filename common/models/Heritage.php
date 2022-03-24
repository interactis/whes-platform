<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;
use common\components\SwissGeometryBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "heritage".
 *
 * @property int $id
 * @property string|null $geom
 * @property int|null $map_position_x
 * @property int|null $map_position_y
 * @property int|null $priority
 * @property bool|null $published
 * @property bool|null $hidden
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Admin[] $admins
 * @property AmbassadorTranslation[] $ambassadorTranslations
 * @property Content[] $contents
 * @property CodeSeries[] $CodeSeries
 * @property HeritageTranslation[] $heritageTranslations
 * @property Media[] $media
 */
class Heritage extends HelperModel
{
	public $translationFields = ['name', 'short_name', 'slug', 'description', 'link_url', 'link_text'];
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
            [
                'class' => SwissGeometryBehavior::className(),
                'type' => SwissGeometryBehavior::GEOMETRY_POINT,
                'attribute' => 'geom',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['priority', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['priority', 'created_at', 'updated_at'], 'integer'],
            [['published', 'hidden'], 'boolean'],
            [['map_position_x', 'map_position_y'],'number', 'min' => 0, 'max' => 100],
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
            'map_position_x' => Yii::t('app', 'Overview Map X-Position (%)'),
            'map_position_y' => Yii::t('app', 'Overview Map Y-Position (%)'),
            'priority' => Yii::t('app', 'Priority'),
            'published' => Yii::t('app', 'Published'),
            'hidden' => Yii::t('app', 'Hidden'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
     * @param $geom
     * Store array to postgis geometry field.
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;
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
     * Gets query for [[CodeSeries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodeSeries()
    {
        return $this->hasMany(CodeSeries::className(), ['heritage_id' => 'id']);
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
    
    public static function getHeritages($forDropdown = false)
    {
        $models = Heritage::find()
        	->joinWith('heritageTranslations')
        	->where(['language_id' => Yii::$app->params['preferredLanguageId']])
        	->orderBy(['short_name' => SORT_ASC])
        	->all();
        	
        if ($forDropdown)
        {
        	return ArrayHelper::map($models, 'short_name', 'short_name');
        }
        else
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
    
    public function getPreviewImage()
    {
    	$format = 600;
    	if (isset($this->media[0]))
    	{
    		$media = $this->media[0];
    		return [
    			'url' => $media->getImageUrl($format),
    			'alt' => $media->title
    		];
    	}
    	else
    	{
    		return [
    			'url' => Media::getPlaceholderUrl($format),
    			'alt' => ''
    		];
		}
	}
}
