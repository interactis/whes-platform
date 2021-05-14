<?php
namespace frontend\components;

use yii\base\BootstrapInterface;
use common\models\Language;

class BootstrapSelector implements BootstrapInterface
{
    public $supportedLanguages = [];

    public function bootstrap($app)
    {
    	$this->_setLanguage($app);
    }
    
    private function _setLanguage($app)
    {
    	// check cookies first
    	$preferredLanguage = isset($app->request->cookies['language']) ? (string)$app->request->cookies['language'] : null;
    	
        if (empty($preferredLanguage))
            $preferredLanguage = $app->request->getPreferredLanguage(\Yii::$app->params['supportedLanguages']);
		
		if (empty($preferredLanguage))
			 $preferredLanguage = "de";
		
		// set preferred language
        $app->language = substr($preferredLanguage,0,2);
        $lang = Language::find()->where(['code' => $app->language])->one();
        
        $app->params['preferredLanguageId'] = $lang->id;
    }
    
}
