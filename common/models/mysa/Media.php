<?php

namespace common\models\mysa;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Html;

/**
 * This is the model class for table "Media".
 *
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $description
 * @property string $author
 * @property string $copyright
 * @property string $fileName
 * @property string $originalFileName
 * @property string $exif
 * @property string $duplicate
 * @property integer $permission
 * @property string $creationTime
 *
 * @property ContentPermission $permission0
 * @property MediaType $type0
 * @property MediaMaster[] $mediaMasters
 * @property TagMaster[] $tagMasters
 */
class Media extends ImageModel
{
	public static function getDb()
	{
		return Yii::$app->dbMysa;
	}
	
	public $image_file;

	private $_sizes = [
    	"crop" => [
    		"xsmall" => 310,
    		"small" => 480,
    		"medium" => 600,
    		"large" => 1200,
    	],
    	"ratio" => [
    		"xsmall" => 310,
    		"small" => 480,
    		"medium" => 600,
    		"large" => 1200,
    	],
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Media';
    }
    
    public function behaviors()
	{
    	return [
    	    [
    	        'class' => TimestampBehavior::className(),
    	        'createdAtAttribute' => 'creationTime',
    	        'updatedAtAttribute' => false,
    	        'value' => new Expression('NOW()'),
    	    ],
    	];
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'permission', 'description', 'author', 'copyright'], 'required'],
            [['type', 'permission'], 'integer'],
            [['exif'], 'string'],
            [['title', 'author', 'copyright'], 'string', 'max' => 150],
            [['description', 'fileName', 'originalFileName'], 'string', 'max' => 255],
            [['permission'], 'exist', 'skipOnError' => true, 'targetClass' => ContentPermission::className(), 'targetAttribute' => ['permission' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => MediaType::className(), 'targetAttribute' => ['type' => 'id']],
        	[['creationTime'], 'safe'],
        	[['duplicate'], 'boolean'],
            ['image_file', 'image', 'extensions' => 'png, jpg',
        		'minWidth' => 1600, 'maxWidth' => 5000,
        		'minHeight' => 600, 'maxHeight' => 5000,
    		],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'author' => Yii::t('app', 'Author'),
            'copyright' => Yii::t('app', 'Copyright'),
            'fileName' => Yii::t('app', 'File Name'),
            'originalFileName' => Yii::t('app', 'Original File Name'),
            'exif' => Yii::t('app', 'Meta Data'),
            'duplicate' => Yii::t('app', 'Duplicate'),
            'imageName' => Yii::t('app', 'Image Name'),
            'permission' => Yii::t('app', 'Permission'),
            'creationTime' => Yii::t('app', 'Creation Time'),
            'image_file' => Yii::t('app', 'Upload Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermission0()
    {
        return $this->hasOne(ContentPermission::className(), ['id' => 'permission']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(MediaType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaMasters()
    {
        return $this->hasMany(MediaMaster::className(), ['mediaId' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagMasters()
    {
        return $this->hasMany(TagMaster::className(), ['mediaId' => 'id']);
    }
    
    public function getRelationLinks($type = 'story')
    {
    	$html = "";
    	foreach ($this->mediaMasters as $master)
    	{
    		if (isset($master->$type))
    		{
				if (isset($master->$type))
				{
					if ($type == 'tag')
					{
						$html .= Html::a($master->$type["name"], [$type .'/update', 'id' => $master->$type["id"], '#' => 'images'], ['target' => '_blank']) ."<br />";
					}
					else
						$html .= Html::a($master->$type["title"], [$type .'/update', 'id' => $master->$type["id"], '#' => 'images'], ['target' => '_blank']) ."<br />";
				}
			}
		}
    	return $html;
	}
	
	public function unlinkImages()
	{
		// unlink thumbs
		foreach ($this->_sizes as $type => $sizes)
		{	
			foreach ($sizes as $size)
			{
				$path = $this->_getImgPath($this->fileName, $size, $type);
				@unlink($path);
			}
		}
		
		// unlink original:
		$originalPath = Yii::getAlias('@backend/uploads/img/'. strtolower($this->tableName()) .'/'. $this->fileName);
		@unlink($originalPath);
	}
	
	private function _getImgPath($fileName, $size, $type)
	{	
		return Yii::getAlias('@frontend/web/img/'. $type .'/'. $size .'/'. $fileName);
	}
}
