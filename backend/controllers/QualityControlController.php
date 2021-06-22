<?php

namespace backend\controllers;

use Yii;
use common\models\Content;
use backend\models\QualityControlSearch;
use backend\components\HelperController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class QualityControlController extends HelperController
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
						'actions' => ['approve', 'edited'],
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function ($rule, $action) {
							$user = Yii::$app->user->identity;
                            return $user->isAdmin();
                        }
					]
				]
			],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
   
    public function actionApprove()
    {
        $searchModel = new QualityControlSearch();
        $searchModel->approved = false;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('approve', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionEdited()
    {
        $searchModel = new QualityControlSearch();
        $searchModel->edited = true;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('edited', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
    protected function findModel($id)
    {
		if (($model = Content::findOne($id)) !== null)
		{
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
