<?php
namespace api\modules\v1\components;
 
use Yii;
use common\models\User;
 
class ApiController extends HelperController
{
	
	public $authRequried = true;
	public $user = false;
	
    public function beforeAction($event)
    {
    	$action = $event->id;
		$verb = Yii::$app->getRequest()->getMethod();
		
		Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
		Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Methods', 'POST, GET');
		Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Headers', 'Auth-Key, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
		
		if ($verb === 'OPTIONS') {
			echo 2;
			exit;
			
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Methods', 'POST, GET');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Headers', 'Auth-Key, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
            //Yii::$app->end();
			//return true;
		}
        
        if (isset($this->actions))
        {
        	if (isset($this->actions[$action]))
        	{
        	    $verbs = $this->actions[$action];
        	}
        	elseif (isset($this->actions['*']))
       		{
        	    $verbs = $this->actions['*'];
        	}
        	else
        	{
        	    return $event->isValid;
        	}
        
    		$allowed = array_map('strtoupper', $verbs);
       
    		if (!in_array($verb, $allowed))
    		{    
    			$this->returnError(400, 'Method not allowed');  
        	}
        	
        	$this->_setLanguage();
        	
        	if ($this->authRequried)
        	{
        		$this->tokenAuth();
        	}
        }
		return true;  
    }
    
    public function tokenAuth($throwError = true)
	{	
		$headers = $this->_getRequestHeaders();
		if (isset($headers["Auth-Key"]))
		{
			if ($this->user = $this->_userAuth($headers["Auth-Key"]))
			{
				if (isset($this->user->interfaceLanguage))
					Yii::$app->language = $this->user->interfaceLanguage->code;
				
				return true;
			}
		}
		
		if ($throwError)
			$this->returnError(401);
	}
	
	private function _setLanguage()
	{
    	$lang = 'de';	
    	
		if (isset($_GET['lang']))
		{
			$code = strtolower($_GET['lang']);
			if (isset(Yii::$app->params['languageIds'][$code]))
				$lang = $code;
		}
		
		Yii::$app->language = $lang;
		$langId = Yii::$app->params['languageIds'][$lang];
		Yii::$app->params['preferredLanguageId'] = $langId;
    }
	
	public function tokenAuthForSignup()
	{	
		$headers = $this->_getRequestHeaders();
		if (isset($headers["Auth-Key"]))
		{
			$this->user = User::findOne([
				'auth_key' => $headers["Auth-Key"],
				'status' => User::STATUS_TEMPORARY
			]);
			
			if ($this->user)
			{ 	
				if (isset($this->user->interfaceLanguage))
					Yii::$app->language = $this->user->interfaceLanguage->code;
					
				return true;
			}
		}
	}
	
	private function _userAuth($authKey)
	{
		return User::findOne(['auth_key' => $authKey]);
	}
    
    public function returnSuccess($attributes, $code = 200, $showRequest = false)
    {
    	$this->setHeader($code);
    	
    	$status = ['status'=> $this->_getStatusCodeMessage($code)];
    	
    	$wording = 'result';
    	if ($showRequest) {
    		$wording = 'request';
    	}
    	
    	$result = [
    		$wording => array_filter(
    			$attributes,
    			function($attribute)
				{
    				return $attribute;
				},
				ARRAY_FILTER_USE_KEY
			)
    	];
    	
    	$response = array_merge($status, $result);
    	
    	echo json_encode($response, JSON_PRETTY_PRINT);
    	    	
    	exit;
    }
    
    public function returnError($code, $message = null, $errors = [])
    {
    	$this->setHeader($code);
        echo json_encode(
        	[
        		'status' => $code,
        		'message' => (!$message ? $this->_getStatusCodeMessage($code) : $message),
        		'errors' => $errors
        	],
        	JSON_PRETTY_PRINT
        );
	   	exit;
    }
    
    public function setHeader($statusCode)
    {
    	$status_header = 'HTTP/1.1 ' . $statusCode . ' ' . $this->_getStatusCodeMessage($statusCode);
		$content_type="application/json; charset=utf-8";
	  	
	  	header($status_header);
	  	header('Content-type: ' . $content_type);
	  	header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: *");
    }
    
    public function encodeResponse($data, $jsonEncode = true)
    {   
    	if ($jsonEncode)
        	$data = json_encode($data, JSON_PRETTY_PRINT);
    
        if(isset($_GET['callback']))
        {
        	$result = $_GET['callback'] .'('. $data .');';
        }
        else
        	$result = $data;
    		
        $this->setHeader(200);
    	echo $result;
    	exit;
    }
    
    private function _getStatusCodeMessage($statusCode)
    {
		// these could be stored in a .ini file and loaded
		$codes = Array(
		    200 => 'Ok',
		    400 => 'Bad Request',
		    401 => 'Unauthorized',
		    403 => 'Forbidden',
		    404 => 'Not Found',
		    500 => 'Internal Server Error',
		    501 => 'Not Implemented',
		);
		return (isset($codes[$statusCode])) ? $codes[$statusCode] : '';
    }
	
    private function _getRequestHeaders()
    {
    	// apache_reqduest_headers is only supported when PHP is installed as an Apache module
    	// extract headers manually if function is not available
    	if (!function_exists('apache_request_headers'))
    	{
        	$arh = array();
        	$rx_http = '/\AHTTP_/';
        
        	foreach($_SERVER as $key => $val)
        	{
            	if( preg_match($rx_http, $key))
            	{
                	$arh_key = preg_replace($rx_http, '', $key);
                    $rx_matches = array();
                    
                    // do some nasty string manipulations to restore the original letter case
                    // this should work in most cases
                    $rx_matches = explode('_', strtolower($arh_key));
                    if(count($rx_matches) > 0 and strlen($arh_key) > 2 )
                    {
                        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
                        $arh_key = implode('-', $rx_matches);
                    }
                    $arh[$arh_key] = $val;
            	}
            }
            
            if (isset($_SERVER['CONTENT_TYPE'])) $arh['Content-Type'] = $_SERVER['CONTENT_TYPE'];
            if (isset($_SERVER['CONTENT_LENGTH'])) $arh['Content-Length'] = $_SERVER['CONTENT_LENGTH'];
            return($arh);
        }
        else
        	return apache_request_headers();
    }
}
