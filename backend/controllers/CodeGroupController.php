<?php

namespace backend\controllers;

use Yii;
use common\models\CodeGroup;
use common\models\CodeSeries;
use backend\models\CodeGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * CodeGroupController implements the CRUD actions for CodeGroup model.
 */
class CodeGroupController extends Controller
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
                        'actions' => ['index', 'create', 'update'],
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
     * Lists all CodeGroup models.
     * @return mixed
     */
    public function actionIndex($id)
    {
    	$codeSeries = $this->_findCodeSeries($id);
        $searchModel = new CodeGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'codeSeries' => $codeSeries,
        ]);
    }

    /**
     * Creates a new CodeGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
    	$codeSeries = $this->_findCodeSeries($id);
        $model = new CodeGroup();
        $model->code_series_id = $codeSeries->id;

        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->assignCodes())
        {
            return $this->redirect(['code/index', 'id' => $codeSeries->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'codeSeries' => $codeSeries,
        ]);
    }
	
    /**
     * Updates an existing CodeGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
     * Finds the CodeGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CodeGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CodeGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
