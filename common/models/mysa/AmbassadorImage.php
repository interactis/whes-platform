<?php
namespace common\models;

use Yii;

class AmbassadorImage extends AmbassadorImageModel
{
	public $image_name;
	public $image_file;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_name'], 'string', 'max' => 36],
            ['image_file', 'image', 'extensions' => 'png, jpg',
        		'minWidth' => 800, 'maxWidth' => 4000,
        		'minHeight' => 300, 'maxHeight' => 4000,
    		]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_name' => Yii::t('app', 'Image Name'),
            'image_file' => Yii::t('app', 'Add Image'), // Bild hinzufügen
        ];
    }
}
