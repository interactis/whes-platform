<?php

namespace backend\controllers;

use Yii;
use common\models\Heritage;
use backend\models\HeritageSearch;
use backend\components\HelperController;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HeritageController implements the CRUD actions for Heritage model.
 */
class HeritageController extends HelperController
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
                            return $user->isAdmin();
                        }
                    ]
                    /*
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->_isOwnerOrAdmin();
                        }
                    ]
                    */
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Heritage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HeritageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Heritage model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Heritage();
        $post = Yii::$app->request->post();
        
        // set geom field separately, as the postgis-behaviour doesn't work with $model->save()
    	$post = $this->setPointGeom($post, $model);
		
		if ($model->load($post))
		{
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false)	&&
        			$model->saveTranslations() &&
        			$model->generateSlugs('short_name')
        		)
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
     * Updates an existing Heritage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$post = Yii::$app->request->post();
		
		// set geom field separately, as the postgis-behaviour doesn't work with $model->save()
    	$post = $this->setPointGeom($post, $model);
		
		if ($model->load($post))
		{
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false)	&&
        			$model->saveTranslations() &&
        			$model->generateSlugs('short_name')
        		)
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
     * Deletes an existing Heritage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->media as $media)
        {
        	$media->removeThumbs();
        }
        
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Heritage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Heritage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Heritage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    private function _isOwnerOrAdmin()
    {   
    	$user = Yii::$app->user->identity;
    	
    	if ($user->isAdmin())
    	{
    		return true;
    	}
    	else
    	{
    		if ($user->heritage_id == Yii::$app->request->get('id'))
    			return true;
    	}
    	
    	return false;
    }
}
