<?php

namespace backend\controllers;

use Yii;
use common\models\Audio;
use common\models\Content;
use backend\models\AudioSearch;
use backend\components\HelperController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class AudioController extends HelperController
{
	private $_content;
	
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

    /**
     * Lists all Audio models.
     * @return mixed
     */
    public function actionIndex($id)
    {
    	$content = $this->_findContent($id);
        $searchModel = new AudioSearch();
        $searchModel->content_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'content' => $content
        ]);
    }
    
    /**
     * Creates a new Audio model.
     * @return mixed
     */
    public function actionCreate($id)
    {
    	$content = $this->_findContent($id);
        $model = new Audio();
        $model->content_id = $content->id;
        
        $post = Yii::$app->request->post();
		if ($model->load($post))
        {
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false) && $model->saveTranslations())
        		{
        			$content->setQualityControl(false, $content->approved, true);
        			
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
            'content' => $content
        ]);
    }

    /**
     * Updates an existing Audio model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $content = $model->content;

        $post = Yii::$app->request->post();
		if ($model->load($post))
        {
        	if ($model->validateTranslations() && $model->validate())
        	{
        		if ($model->save(false) && $model->saveTranslations())
        		{
        			$content->setQualityControl(false, $content->approved, true);
        			
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
            'content' => $content
        ]);
    }

    /**
     * Deletes an existing Audio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->removeFiles();
        $model->delete();
        return $this->redirect(['index', 'id' => $model->content_id]);
    }
	
	private function _findContent($id)
    {
    	if (empty($this->_content))
    	{
    		if (($model = Content::findOne($id)) !== null)
    		{
    			$this->_content = $model;
				return $model;
			}
			
			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
        else
			return $this->_content;
    }
	
    /**
     * Finds the Audio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Audio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Audio::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
