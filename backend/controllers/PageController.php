<?php

namespace backend\controllers;

use Yii;
use common\models\Page;
use backend\models\PageSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        	'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                        	$user = Yii::$app->user->identity;
                            return $user->isAdmin();
                        }
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
        $post = Yii::$app->request->post();
		
		if ($model->load($post))
        {
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false) && $model->saveTranslations($post)) {
        			Yii::$app->getSession()->setFlash(
        				'success',
        				'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
        			);
            	}
       		}
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }
	
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
