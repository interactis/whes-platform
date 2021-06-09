<?php
namespace frontend\components;

use Yii;
use yii\base\Component;

class Helpers extends Component
{
	private $_rucksackIds = [];

	public function shortenString($string, $length = 160)
	{	
		$string = strip_tags($string);

		if (strlen($string) > $length)
			$string = substr($string, 0, strpos($string, ' ', $length)) .' ...';
		
		return $string;
	}
	
	public function getSbbLink($station, $formTo = 'nach')
	{
		return Yii::t('app', 'https://www.sbb.ch/en/buying/pages/fahrplan/fahrplan.xhtml') .'?'. $formTo .'='. urldecode($station);
	}
	
	public function getRucksackIds()
    {
    	if (!$this->_rucksackIds)
    	{
    		$cookies = Yii::$app->request->cookies;
    		$cookie = $cookies->get('rucksack');
    		
    		if (!empty($cookie->value))
    			$this->_rucksackIds = explode(",", $cookie);
    	}
    	
    	return $this->_rucksackIds;
    }
	
}
