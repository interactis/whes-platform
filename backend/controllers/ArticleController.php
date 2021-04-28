<?php

namespace backend\controllers;

use Yii;
use common\models\Content;
use common\models\Article;
use backend\models\ArticleSearch;
use backend\components\HelperController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends HelperController
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
						'actions' => ['index'],
						'allow' => true,
						'roles' => ['@']
					],
					[
						'actions' => ['create', 'update', 'delete'],
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function ($rule, $action) {
							return $this->isOwnerOrAdmin();
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
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Article();
        $contentModel = $this->newContentModel(Content::TYPE_ARTICLE);
        $post = Yii::$app->request->post();

        if ($model->load($post))
        { 
        	if ($model->validateTranslations($post) && $model->validate())
        	{
        		$contentModel->attributes .....;
        		$contentModel->save(false);
    			$model->content_id = $contentModel->id;
				
        		if ($model->save(false)	&&
        			$model->saveTranslations($post) &&
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
        ]);
    }
    
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
  
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
