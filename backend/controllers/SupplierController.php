<?php

namespace backend\controllers;

use Yii;
use common\models\Supplier;
use backend\models\SupplierSearch;
use backend\components\HelperController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends HelperController
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
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                        	if (Yii::$app->request->get('id') !== null)
    							$id = Yii::$app->request->get('id');
    						
    						if (Yii::$app->request->post('id') !== null)
    							$id = Yii::$app->request->post('id');
    						
                            $model = $this->findModel($id);
                            return $this->isOwnerOrAdmin($model->heritage_id);
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
    
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {  	
        $model = new Supplier();
        
        $post = Yii::$app->request->post();
		if ($model->load($post))
        {
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false) && $model->saveTranslations())
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
            'model' => $model
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        $post = Yii::$app->request->post();
		if ($model->load($post))
        {
        	if ($model->remove)
        	{
        		$model->delete();
        		
        		Yii::$app->getSession()->setFlash(
					'success',
					'<span class="glyphicon glyphicon-ok-sign"></span> Supplier has been removed.'
				);

        		return $this->redirect(['create']);
        	}
        	
        	
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false) && $model->saveTranslations())
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
            'model' => $model
        ]);
    }
	
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($id)
    {        
		if (($model = Supplier::findOne($id)) !== null)
		{
			return $model;
		}
		else
        	throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
