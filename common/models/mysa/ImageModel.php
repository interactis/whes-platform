<?php
namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;
use yii\base\Model;

class ImageModel extends \yii\db\ActiveRecord
{
		
	 /**
     * Image upload handling
     */
    public function createThumbs()
    {	    	
    	$this->image_file = UploadedFile::getInstance($this, 'image_file');
    	if (!empty($this->image_file))
    	{
    		$this->fileName = $this->createImageName();
    		$this->originalFileName = $this->image_file->name;
    		
    		// save original image
    		$original = Yii::getAlias('@backend/uploads/img/'. strtolower($this->tableName()) .'/'. $this->fileName);
    		$this->image_file->saveAs($original);
    		
    		$this->exif = json_encode(@exif_read_data($original));
    		
			// generate ratio thumbs
			$this->generateThumbs('ratio', $original, $this->fileName);
			
			// generate crop thumbs
			$this->generateThumbs('crop', $original, $this->fileName);
		}
		return $this->fileName;
    }
    
    protected function generateThumbs($type, $original, $imageName)
    {
    	$modes = $this->getModes();
		$imageFormats = \Yii::$app->params['imageFormatsUpload'];
		
    	foreach($imageFormats[$type] as $format)
		{
			$mode = $modes[$type];
			$path = $mode["path"] ."/". $format["width"] ."/";
			Image::$thumbnailBackgroundColor = '000';
			Image::thumbnail($original, $format["width"], $format["height"], $mode["mode"])
    			->save($path . $imageName, ['quality' => 80]);
		}
		return true;
    }
    
    protected function createImageName()
    {
    	$imgName = \Yii::$app->security->generateRandomString() .'.'. $this->image_file->extension;
    	
    	if (file_exists(Yii::getAlias('@backend/uploads/img/'. strtolower($this->tableName()) .'/'. $imgName)))
    	{
    		return $this->createImageName();
    	}
    	else
    		return $imgName;
    }
    
    protected function getModes()
    {
    	$imgPath = Yii::getAlias('@frontend/web/img');
    	
    	return [
    		"crop" => [
    			"mode" => ManipulatorInterface::THUMBNAIL_OUTBOUND,
    			"path" => $imgPath ."/crop"
    		],
    		"ratio" => [
    			"mode" => ManipulatorInterface::THUMBNAIL_INSET,
    			"path" => $imgPath ."/ratio"
    		]
    	];
    }
    
    public function removeThumbs()
    {
    	$modes = $this->getModes();
		$imageFormats = \Yii::$app->params['imageFormatsUpload'];
		$types = ['crop', 'ratio'];
		
		// delte thumbs
		foreach($types as $type)
		{
    		foreach($imageFormats[$type] as $format)
			{
				$mode = $modes[$type];
				$file = $mode["path"] ."/". $format["width"] ."/". $this->fileName;
				
				if (file_exists($file))
    				unlink($file);
			}
    	}
    	
    	// delete original
    	$originalFile = Yii::getAlias('@backend/uploads/img/'. strtolower($this->tableName()) .'/'. $this->fileName);
    	if (file_exists($originalFile))
    		unlink($originalFile);
    }
}
