<?php
namespace api\modules\v1\components;

use Yii;
use yii\base\Component;

class Helpers extends Component
{
    public function shortenString($string, $length = 160)
	{	
		$string = strip_tags($string);

		if (strlen($string) > $length)
			$string = substr($string, 0, strpos($string, ' ', $length)) .' ...';
		
		return $string;
	}
}
