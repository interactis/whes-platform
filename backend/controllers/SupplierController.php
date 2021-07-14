<?php

namespace backend\controllers;

use Yii;
use common\models\Supplier;
use common\models\Content;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
	private $_model;
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
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->_isContentOwnerOrAdmin(Yii::$app->request->get('id'));
                        }
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
                            return $this->_isContentOwnerOrAdmin($model->content->id);
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
    
    public function actionCreate($id)
    {
    	$content = $this->_findContent($id);
    	if (isset($content->supplier))
    		return $this->redirect(['update', 'id' => $content->supplier->id]);	
    	
        $model = new Supplier();
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

        return $this->render('supplier', [
        	'content' => $content,
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$content = $model->content;
		
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

        		return $this->redirect(['create', 'id' => $content->id]);
        	}
        	
        	
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

        return $this->render('supplier', [
        	'content' => $content,
            'model' => $model
        ]);
    }
	
	/*
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    */
    
    protected function findModel($id)
    {
    	if (!empty($this->_model))
    		return $this->_model;
        
		if (($model = Supplier::findOne($id)) !== null)
		{
			$this->_model = $model;
			$this->_content = $model->content;
			return $model;
		}
		else
        	throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
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
    
    private function _isContentOwnerOrAdmin($id)
    {   
    	$user = Yii::$app->user->identity;
    	
    	if ($user->isAdmin())
    	{
    		return true;
    	}
    	else
    	{
    		$content = $this->_findContent($id);
    		if ($content->heritage_id == $user->heritage_id)
    			return true;
    	}
    	
    	return false;
    }
}
