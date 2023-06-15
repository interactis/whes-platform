<?php
namespace frontend\components;

use yii\base\BootstrapInterface;
use common\models\Language;

class BootstrapSelector implements BootstrapInterface
{
    public $supportedLanguages = [];

    public function bootstrap($app)
    {
       	$this->_setFrontendType($app);
       	
       	if ($app->params['isEduFrontend'])
       	{
       		$this->_setLanguage($app, 'de');
       	}
    	else
    		$this->_setLanguage($app);
    }
    
    private function _setFrontendType($app)
    {
    	$domain = $_SERVER['SERVER_NAME'];
       	if ($domain == $app->params['frontends']['edu'])
       	{
       		$app->params['isVisitorFrontend'] = false;
       		$app->params['isEduFrontend'] = true;
       	}
    }
    
    private function _setLanguage($app, $setLang = false)
    {	
    	if ($setLang)
    	{
    		$app->language = $setLang;
    	}
    	else
    	{
    		// check cookies first
    		$preferredLanguage = isset($app->request->cookies['language']) ? (string)$app->request->cookies['language'] : null;
    	
			if (empty($preferredLanguage))
				$preferredLanguage = $app->request->getPreferredLanguage(\Yii::$app->params['supportedLanguages']);
		
			if (empty($preferredLanguage))
				 $preferredLanguage = "de";
		
			// set preferred language
			$app->language = substr($preferredLanguage,0,2);
    	}
    	
        $lang = Language::find()->where(['code' => $app->language])->one();
        $app->params['preferredLanguageId'] = $lang->id;
    }   
}
