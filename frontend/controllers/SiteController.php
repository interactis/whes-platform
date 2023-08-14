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
    	
    	$filtersArray = [];
    	if (!empty($filters))
    		$filtersArray = explode(',', $filters);
    	
    	if (Yii::$app->params['frontendType'] == 'edu')
    	{
    		$model = $this->_findPage(5);
    	}
    	else
    		$model = $this->_findPage(1);
    	
    	$totalContent = $this->totalContent($filters);
    	
        return $this->render('index', [
    		'model' => $model,
    		'media' => $this->_randomMedia(),
    		'content' => $this->findFilterContent($filters), 
    		'filters' => $filtersArray,
    		'totalContent' => $totalContent,
    		'showMoreBtn' => $this->showMoreBtn($totalContent)
    	]);
    }
	
    public function actionImpressum()
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
    
    public function actionCookie($ok)
    {
    	$this->layout = false;
    	
		if ($ok)
		{
			$cookie = new Cookie([
    			'name' => 'okCookie',
    			'value' => true,
    			'expire' => time()+60*60*24*365,
			]);
			Yii::$app->response->cookies->add($cookie);
		}
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
