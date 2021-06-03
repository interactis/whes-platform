<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
use yii\db\Expression;
use frontend\components\HelperController;
use common\models\Page;
use common\models\Heritage;

/**
 * Site controller
 */
class SiteController extends HelperController
{
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
    	$filters = $this->getFilterCookie();
    	
        return $this->render('index', [
    		'model' => $this->_findPage(1),
    		'media' => $this->_randomMedia(),
    		'content' => $this->findFilterContent($filters), 
    		'filters' => explode(',', $filters)
    	]);
    }
	
    public function actionAbout()
    {
        return $this->render('page', [
        	'model' => $this->_findPage(2)
        ]);
    }
    
    public function actionPrivacyPolicy()
    {
        return $this->render('page', [
        	'model' => $this->_findPage(3)
        ]);
    }
    
    public function actionContact()
    {
        return $this->render('page', [
        	'model' => $this->_findPage(4)
        ]);
    }
    
    public function actionLanguage($lang)
    {
		$lang = strtolower($lang);
		if (in_array($lang, \Yii::$app->params['supportedLanguages']))
		{
			$languageCookie = new Cookie([
    			'name' => 'language',
    			'value' => $lang,
			]);
			Yii::$app->response->cookies->add($languageCookie);
		}
		return $this->redirect(Yii::$app->request->referrer);
    }
    
    private function _findPage($id)
    {
        $model = Page::findOne($id);
		
		if ($model !== null)
            return $model;

        throw new NotFoundHttpException();
    }
    
    private function _randomMedia()
    {
        $models = Heritage::find()
        	->where([
        		'published' => true,
        		'hidden' => false
        	])
        	->orderBy(new Expression('random()'))
        	->limit(6)
        	->all();
		
		$media = [];
		foreach($models as $model)
		{
			if (isset($model->media[0]))
				$media[] = $model->media[0];
		}
		
		return $media;
    }
}
