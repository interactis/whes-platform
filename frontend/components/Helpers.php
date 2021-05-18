<?php
namespace frontend\components;

use Yii;
use yii\base\Component;

class Helpers extends Component
{

	public function getImgUrl($model, $size)
	{	
		
		$imgUrl = '/img/layout/placeholder/'. $size .'/placeholder.jpg';
		
		
		
		return $imgUrl;
	}
	
	public function getShortDescription($model, $contentfulField = 'shorttext')
	{	
		$maxLenght = 160;
		$html = $this->parseMarkdown($model->$contentfulField);
		$description = strip_tags($html);
		
		if (strlen($description) > $maxLenght)
			$description = substr($description, 0, strpos($description, ' ', $maxLenght)) .' ...';
		
		return $description;
	}
	
	public function getRelatedContenfulItemsAsString($models)
	{
		$items = [];
		foreach($models as $model)
			$items[] = $model->name;
		
		return implode(', ', $items);
	}
	
	public function parseMarkdown($text)
	{	
		$parsedown = new Parsedown();
		return $parsedown->text($text);
	}
	
	public function printLinkButton($url, $createUrl = false)
	{
		$trimed = preg_replace('#^https?://#', '', rtrim($url, '/'));
		if (!$createUrl)
		{
			echo '<a href="'. $url .'" target="_blank" class="btn btn-primary"><span>'. $trimed .'</span></a>';
		}
		else
			echo '<a href="http://'. $trimed .'" target="_blank" class="btn btn-primary"><span>'. $trimed .'</span></a>';
	}
	
	public function printClassification($classification)
	{	
		echo '<img class="stars" src="/img/layout/classification/'. $classification .'.svg" alt="'. Yii::t('mice', '{stars} Star', ['stars' => $classification]) .'">';
	}
	
	public function printRequirement($requirement)
	{	
		if (empty($requirement))
			$requirement = 0;
	
		echo '<img class="requirement" src="/img/layout/dots/'. $requirement .'.svg" alt="'. $requirement .'">';
	}
	
	public function getOpenInSeason($model)
	{
		$open = [];
		$allYear = true;
		
		if (!empty($model->openInWinter))
		{
			$open[] = 'Winter';
		}
		else
		{
			$allYear = false;
			$open[] = Yii::t('mice', 'Winter on request');
		}
		
		if (!empty($model->openInSummer))
		{
			$open[] = Yii::t('mice', 'Summer');
		}
		else
		{
			$allYear = false;
			$open[] = Yii::t('mice', 'Summer on request');
		}
		
		if ($allYear)
		{
			return Yii::t('mice', 'All year');
		}
		else
			return implode(', ', $open);
							
	}
	
	public function getOfferText($type, $count)
	{
		$text = $type;
		if ($count == 1)
			$text = substr($text, 0, -1);
		
		return $count .' '. $text;
	}
	
	public function getBookmarkCookie($type, $explode = true) {
    	$cookies = Yii::$app->request->cookies;
    	
    	$ids = '';
    	if ($explode)
    		$ids = [];
    	
    	if ($cookie = $cookies->get($type .'_bookmarks'))
    	{
    		if (!empty($cookie->value))
    		{
    			if ($explode)
    			{
    				$ids = explode(",", $cookie);
    			}
    			else
    				$ids = $cookie;
    		}
    	}
    	return $ids;
    }
    
    public function isBookmarked($type, $id)
    {
    	$bookmarkIds = $this->getBookmarkCookie($type);
    	
    	if (in_array($id, $bookmarkIds))
    	{
    		return true;
    	}
    	else
    		return false;
    }
    
    public function getBookmarsCountHtml($type, $bookmarks)
    {
    	$html = '';
		$count = count($bookmarks[$type]);
		if ($count > 0)
		{
			$url = '/bookmarks#'. $type;
			
			$html = '<span class="bookmark-index">
				<a href="'. $url .'" class="bookmark-link">
					<span class="icon-container">'.
						Yii::$app->controller->renderPartial('//common/_bookmarkIcon')
					.'</span>
					<span class="bookmark-count">'. sprintf("%02d", $count) .'</span>
				</a>
				<a href="'. $url .'">'. Yii::t('mice', ucfirst($type)) .'</a>
			</span>';
		}
		return $html;
    }
    
    public function getDurations()
    {
		$durations = [
			0 => Yii::t('mice', 'Duration'),
			1 => $this->getDurationsText(1)
		];
		
		for ($i = 2; $i <= $this->_maxDuration; $i++)
		{
			$durations[$i] = $this->getDurationsText($i);	
		}
		
		return $durations;
    }
    
    public function getDurationsText($value)
    {
    	if (!is_numeric($value))
    		return false;
    		
    	if ($value == 1)
    	{
    		return '1 '. Yii::t('mice', 'day') .' '. Yii::t('mice', '(or less)');
    	}
    	else
    	{
    		if ($value == $this->_maxDuration)
    		{
    			return $value .' '. Yii::t('mice', 'days')  .' '. Yii::t('mice', '(or more)');
    		}
    		else
    			return $value .' '. Yii::t('mice', 'days');
    	}
    }
    
    public function getPersons()
    {
    	$persons = [
    		0 => Yii::t('mice', 'Number of Persons'),
    		1 => $this->getPersonsText(1)
    	];
    	
		for ($i = 2; $i <= 50; $i++)
		{
			$persons[$i] = $this->getPersonsText($i);
		}

		$step = 10;
		for ($i = 51; $i <= 100; $i += $step)
		{
			$until = $i+($step-1);
			$value = $i .'-'. $until;
			$persons[$value] = $this->getPersonsText($value);
		}

		$step = 20;
		for ($i = 101; $i <= 300; $i += $step)
		{
			$until = $i+($step-1);
			$value = $i .'-'. $until;
			$persons[$value] = $this->getPersonsText($value);
		}

		$step = 50;
		for ($i = 301; $i <= 1000; $i += $step)
		{
			$until = $i+($step-1);
			$value = $i .'-'. $until;
			$persons[$value] = $this->getPersonsText($value);
		}
		
		$persons[1000] = $this->getPersonsText(1000);
		
		return $persons;
    }
    
    public function getPersonsText($value)
    {
    	if ($value == 1)
    	{
    		return '1 '. Yii::t('mice', 'person');
    	}
    	else
    	{
    		$text = str_replace('-', ' – ', $value) .' '. Yii::t('mice', 'persons');
    		
    		if ($value == $this->_maxPersons)
    			$text = '> '. $text;
    			
    		return $text;
    	}
    }
    
    public function getPurposes($showOters = false)
	{
		$purposes = [];
		foreach(Yii::$app->params['purposes'] as $key => $value)
		{
			$purposes[$key] = Yii::t('mice', $value);
		}
		
		if ($showOters)
			$purposes['Other'] = Yii::t('mice', 'Other');
		
		return $purposes;
	}
	
	public function getPurposeText($purposeId)
	{
		if (isset(Yii::$app->params['purposes'][$purposeId]))
			return Yii::t('mice', Yii::$app->params['purposes'][$purposeId]);
		
		if ($purposeId == 'Other')
			return Yii::t('mice', 'Other');
		
		return false;
	}
	
	public function getContentfulClient($space = 'insideLaax')
	{
		$spaceParams = Yii::$app->params['contentful'][$space];
		
		return new \Contentful\Delivery\Client(
			$spaceParams['accessToken'],
			$spaceParams['spaceId']
		);
	}
	
	public function getContentfulEntries($client, $contentType, $q = false, $orderBy = false, $offset = 0, $limit = true)
	{
		$query = new \Contentful\Delivery\Query();
		$query->setContentType($contentType)
    		->setLocale($this->_getExtendedLocale());
    	
    	if ($q)
    	{
    		foreach($q as $key => $val)
    		{
    			if (is_array($val))
    			{
    				foreach($val as $operator => $value)
    				{
    					$query->where($key . $operator, $value);
    					break;
    				}
    			}
    			else
    				$query->where($key, $val);
    		}
    	}
    	
    	if ($orderBy)
    		$query->orderBy($orderBy);
    	
    	if ($limit)
    	{
    		$query->setLimit(Yii::$app->params['showMaxEntries']);
    	}
    	else
    		$query->setLimit(100); // default would be 100
    	
    	$query->setSkip($offset);
    	
    	return $client->getEntries($query);
	}
	
	private function _getExtendedLocale()
	{
		$lang = \Yii::$app->language;
		
		switch ($lang)
		{
			case 'de':
				return 'de-CH';
			case 'en':
				return 'en-US';
			default:
				return "*";
		}
	}
}
