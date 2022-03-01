<?php

namespace backend\controllers;

use Yii;
use common\models\CodeSeries;
use common\models\Code;
use backend\models\CodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * CodeController implements the CRUD actions for Code model.
 */
class CodeController extends Controller
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
                        'actions' => ['index', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                        	$user = Yii::$app->user->identity;
                            return $user->isAdmin();
                        }
                    ],
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

    /**
     * Lists all Code models.
     * @return mixed
     */
    public function actionIndex($id)
    {
    	$codeSeries = $this->_findCodeSeries($id);
        $searchModel = new CodeSearch();
        $searchModel->code_series_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$downloadDataProvider = $searchModel->getDownloadData($dataProvider);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'downloadDataProvider' => $downloadDataProvider,
            'codeSeries' => $codeSeries
        ]);
    }

    /**
     * Updates an existing Code model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
        	$model->active = false;
        	if (!empty($model->content_id))
        		$model->active = true;
        	
        	$model->save(false);
        	
        	Yii::$app->getSession()->setFlash(
				'success',
				'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
			);
			return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'codeSeries' => $model->codeSeries
        ]);
    }
	
    private function _findCodeSeries($id)
    {
        if (($model = CodeSeries::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the Code model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Code the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Code::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
