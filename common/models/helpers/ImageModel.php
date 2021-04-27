<?php

namespace common\models\helpers;;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;

/**
 * This is the ImageModel class
 *
 */
class ImageModel extends \yii\db\ActiveRecord
{

	 /**
     * Image upload handling
     */
    public function createThumbs($frontendPath, $imageName = "image_name", $imageFile = "image_file", $useByName = false, $byName = '')
    {	    	
    	if ($useByName)
    	{
    		$this->$imageFile = UploadedFile::getInstanceByName($byName);
    	}
    	else
    		$this->$imageFile = UploadedFile::getInstance($this, $imageFile);
    		
    	if (!empty($this->$imageFile))
    	{
    		// if an image exists remove thumbs first
    		$this->removeThumbs($imageName, $frontendPath);
    		$this->$imageName = $this->createImageName($imageFile);
    	
    		// save original image
    		$original = Yii::getAlias('@common/uploads/img/'. $this->tableName() .'/'. $this->$imageName);
    		$this->$imageFile->saveAs($original);
    		chmod($original, 0777);
    			
			// resize images
			//$this->generateThumbs('ratio', $original, $this->$imageName, $frontendPath);
			$this->resize($original, $this->$imageName, $frontendPath);
			
			// generate crop thumbs
			$this->generateThumbs('crop', $original, $this->$imageName, $frontendPath);
		}
		return $this->$imageName;
    }
    
    protected function generateThumbs($type, $original, $imageName, $frontendPath)
    {
    	$modes = $this->getModes($frontendPath);
		$imageFormats = \Yii::$app->params['imageFormats'];
		
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
    
    protected function resize($original, $imageName, $frontendPath)
    {
    	$modes = $this->getModes($frontendPath);
		$imageFormats = \Yii::$app->params['imageFormats'];
		
    	foreach($imageFormats['ratio'] as $format)
		{
			$mode = $modes['ratio'];
			$path = $mode["path"] ."/". $format["width"] ."/";
			
			$imagine = Image::getImagine();
			$imagine = $imagine->open($original);
			$imagine->resize($imagine->getSize()->widen($format["width"]))->save($path . $imageName);
		}
		return true;
    }
    
    protected function createImageName($imageFile = "image_file", $i = 0)
    {	
    	$imgName = $this->normalizeFilneName($this->$imageFile->baseName);
    	
    	if ($i > 0)
    		$imgName = $imgName .'-'. $i;
    	
    	$imgName = $imgName .'.'. $this->$imageFile->extension;
    	
    	if (file_exists(Yii::getAlias('@common/uploads/img/'. $this->tableName() .'/'. $imgName)))
    	{
    		$i = $i+1;
    		return $this->createImageName($imageFile, $i);
    	}
    	else
    		return $imgName;
    }
    
    public function normalizeFilneName($str)
	{
		$str = strip_tags($str); 
		$str = preg_replace('/[\r\n\t ]+/', ' ', $str);
		$str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
		//$str = strtolower($str);
		$str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
		$str = htmlentities($str, ENT_QUOTES, "utf-8");
		$str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
		$str = str_replace(' ', '-', $str);
		$str = rawurlencode($str);
		$str = str_replace('%', '-', $str);
		
		// trim
		$max = 240;
		if (strlen($str) > $max)
			$str = substr($str, 0, $max);
		
		return $str;
	}
    
    protected function getModes($frontendPath)
    {
    	$imgPath = $frontendPath . $this->tableName();
    	
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
    
    public function removeThumbs($imageName = "image_name", $frontendPath)
    {
    	if (!empty($this->$imageName))
    	{
			$modes = $this->getModes($frontendPath);
			$imageFormats = \Yii::$app->params['imageFormats'];
			$types = ['crop', 'ratio'];
		
			// delte thumbs
			foreach($types as $type)
			{
				foreach($imageFormats[$type] as $format)
				{
					$mode = $modes[$type];
					$file = $mode["path"] ."/". $format["width"] ."/". $this->$imageName;
				
					if (file_exists($file))
						unlink($file);
				}
			}
		
			// delete original
			$originalFile = Yii::getAlias('@common/uploads/img/'. $this->tableName() .'/'. $this->$imageName);
			if (file_exists($originalFile))
				unlink($originalFile);
		}
    }
    
    public function getImageHtml($format, $class, $alt, $frontendUrl, $imageName = "image_name", $type = 'crop')
    {
    	$url = $this->getImageUrl($format, $frontendUrl, $imageName, $type);
		return '<img src="'. $url .'" class="'. $class .'" alt="'. $alt .'">';		
	}
	
	public function getImageUrl($format, $frontendUrl, $imageName = "image_name", $type = 'crop')
    {
    	$url = $frontendUrl ."img/layout/placeholder/". $format ."/placeholder.jpg";
    	if (!empty($this->$imageName))
    	{
    		$url = $frontendUrl ."img/". $this->tableName() ."/". $type ."/". $format ."/". $this->$imageName;
    	}
		return $url;		
	}
}
