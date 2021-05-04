<?php

namespace backend\controllers;

use Yii;
use common\models\Content;
use common\models\Route;
use backend\models\RouteSearch;
use backend\components\HelperController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * RouteController implements the CRUD actions for Route model.
 */
class RouteController extends HelperController
{
	private $_model;
	
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
                            return $this->isOwnerOrAdmin($model->content->heritage_id);
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
   
    public function actionIndex()
    {
        $searchModel = new RouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Route();
        $contentModel = $this->newContentModel(Content::TYPE_ROUTE);
        $post = Yii::$app->request->post();

        if ($model->load($post) && $contentModel->load($post))
        { 
        	if ($model->validateTranslations() && $model->validate() && $contentModel->validate())
        	{
        		$contentModel->save(false);
    			$model->content_id = $contentModel->id;	
        		if ($model->save(false)	&&
        			$model->saveTranslations() &&
        			$model->saveTags() &&
        			$model->saveFlags() &&
        			$model->generateSlugs()
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
            'contentModel' => $contentModel,
        ]);
    }
    
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
        $contentModel = $model->content;
        $post = Yii::$app->request->post();

        if ($model->load($post) && $contentModel->load($post))
        { 
        	if ($model->validateTranslations() && $model->validate() && $contentModel->validate())
        	{
        	
        		if ($contentModel->save(false) &&
        			$model->save(false)	&&
        			$model->saveTranslations() &&
        			$model->saveTags() &&
        			$model->saveFlags() &&
        			$model->generateSlugs()
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
            'contentModel' => $contentModel,
        ]);
    }
    
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->content->media as $media)
        {
        	$media->removeThumbs();
        }
        
        $model->delete();

        return $this->redirect(['index']);
    }
	
    protected function findModel($id)
    {
    	if (!empty($this->_model))
    	{
    		return $this->_model;
    	}
    	else
    	{
    		if (($model = Route::findOne($id)) !== null)
    		{
    			$this->_model = $model;
				return $model;
			}

			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
    }
}
