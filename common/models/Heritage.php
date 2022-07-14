<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;
use common\components\SwissGeometryBehavior;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "heritage".
 *
 * @property int $id
 * @property int|null $type
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
	const TYPE_WORLD_HERITAGE = 1;
    const TYPE_INTAGNIBLE = 2;
    const TYPE_BIOSPHERE = 3;
    
	public $translationFields = ['name', 'short_name', 'slug', 'description', 'link_url', 'link_text'];
	public $requiredTranslationFields = ['name', 'short_name', 'description'];
	public $badgeFile;
	
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
            [
                'class' => SwissGeometryBehavior::className(),
                'type' => SwissGeometryBehavior::GEOMETRY_MULTIPOLYGON,
                'attribute' => 'perimeter',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'priority', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['type', 'priority', 'created_at', 'updated_at'], 'integer'],
            [['published', 'hidden'], 'boolean'],
            [['map_position_x', 'map_position_y'],'number', 'min' => 0, 'max' => 100],
            //[['perimeter'], 'string'],
            ['badgeFile', 'file', 'extensions' => ['svg']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'geom' => Yii::t('app', 'Geom'),
            'perimeter' => Yii::t('app', 'Perimeter'),
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
     * Gets query for [[ProfileItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfileItems()
    {
        return $this->hasMany(ProfileItem::className(), ['heritage_id' => 'id'])
        	->orderBy(['order' => SORT_ASC]);
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
    
    public static function getActiveHeritages($type = false)
    {
        $models = Heritage::find()
        	->joinWith('heritageTranslations')
        	->where([
        		'language_id' => Yii::$app->params['preferredLanguageId'],
        		'published'=> true,
        		'hidden' => false
        	]);
        
        if ($type)
        {
        	$models->andWhere([
        		'type' => $type
        	]);
        }
        
        return $models->orderBy(['short_name' => SORT_ASC])->all();
    }
    
    public static function getTypes()
    {
        return [
        	1 => 'UNESCO World Heritage',
        	2 => 'UNESCO Intangible Cultural Heritage',
        	3 => 'UNESCO Biosphere Reserve'
        ];
    }
	
	public function getLabel()
    {
    	$types = $this::getTypes();
        return Yii::t('app', $types[$this->type]);
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
    
    public function getBadge($class = "")
    {  	
    	$path = $this->getBadgeFilePath();
		if (file_exists($path))
		{
			$url = Yii::$app->params['frontendUrl'] ."img/heritage/badge/". $this->id .'.svg?'. Yii::$app->security->generateRandomString(6);
			return '<img src="'. $url .'" class="heritage-badge '. $class .'" alt="Heritage icon">';		
		}
		else
			return false;		
	}
    
    public function saveBadgeFile()
    {
    	$file = UploadedFile::getInstance($this, 'badgeFile');
    	
		if (!empty($file))
		{   
			// delete old file
			$this->_removeBadgeFile();
				
			// save new file
			$path = $this->getBadgeFilePath();			
			$file->saveAs($path);
		}
		
		return true;
    }
    
    public function getBadgeFilePath()
    {
		$path = '/img/heritage/badge/'. $this->id .'.svg';
		return Yii::getAlias('@frontend/web'. $path);
    }
    
    private function _removeBadgeFile()
    {
		$path = $this->getBadgeFilePath();
		if (file_exists($path))
			unlink($path);	
    }
}
