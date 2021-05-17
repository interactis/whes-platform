<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Cookie;
use common\models\Page;

/**
 * Site controller
 */
class SiteController extends Controller
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
        return $this->render('index', [
    		'model' => $this->_findPage(1)
    	]);
    }
    
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
	
    public function actionAbout()
    {
        return $this->render('about');
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
    
}
