<?php

namespace backend\controllers;

use Yii;
use common\models\Flag;
use backend\models\FlagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * FlagController implements the CRUD actions for Flag model.
 */
class FlagController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                        	$user = Yii::$app->user->identity;
                            return $user->isSuperAdmin();
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

    /**
     * Lists all Flag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FlagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Flag model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Flag();
        $post = Yii::$app->request->post();
		
		if ($model->load($post))
		{
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false)	&& $model->saveTranslations())
        		{        						
					Yii::$app->getSession()->setFlash(
						'success',
						'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
					);
					return $this->redirect(['update', 'id' => $model->id]);
				}
       		}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Flag model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$post = Yii::$app->request->post();
		
		if ($model->load($post))
		{
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false)	&& $model->saveTranslations())
        		{        						
					Yii::$app->getSession()->setFlash(
						'success',
						'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
					);
					return $this->redirect(['update', 'id' => $model->id]);	
				}
       		}
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Flag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Flag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Flag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Flag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
