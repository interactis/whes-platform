<?php

namespace backend\controllers;

use Yii;
use common\models\Media;
use common\models\Heritage;
use common\models\Content;
use backend\models\MediaSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MediaController implements the CRUD actions for Media model.
 */
class MediaController extends Controller
{
	private $_heritage;
	private $_content;
	private $_page;
	
    public function behaviors()
    {
        return [
        	'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['heritage', 'create-heritage-media'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->_isHeritageOwnerOrAdmin(Yii::$app->request->get('id'));
                        }
                    ],
                    [
                        'actions' => ['content', 'create-content-media'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->_isContentOwnerOrAdmin(Yii::$app->request->get('id'));
                        }
                    ],
                    /*
                    [
                        'actions' => ['page'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                        	$user = Yii::$app->user->identity;
                            return $user->isAdmin();
                        }
                    ],
                    */
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $model = $this->findModel(Yii::$app->request->get('id'));
                            switch ($model->contentType)
                            {
								case 'heritage':
									return $this->_isHeritageOwnerOrAdmin($model->heritage_id);
									break;
								case 'content':
									return $this->_isContentOwnerOrAdmin($model->content_id);
									break;
								default:
									return $user->isAdmin();
							}
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
	
    public function actionHeritage($id)
    {
    	$heritage = $this->_findHeritage($id);
    	
        return $this->render('heritage', [
        	'heritage' => $heritage,
            'models' => $heritage->media,
        ]);
    }
	
    public function actionCreateHeritageMedia($id)
    {
    	$heritage = $this->_findHeritage($id);
        $model = new Media();
        $model->heritage_id = $heritage->id;
        
        $post = Yii::$app->request->post();
		if ($model->load($post))
        {
        	if ($model->validateTranslations() && $model->validate())
        	{
        		$model->createThumbs(Yii::getAlias('@frontend/web/img/'));
        		
        		if ($model->save(false) && $model->saveTranslations())
        		{
        			Yii::$app->getSession()->setFlash(
        				'success',
        				'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
        			);
        			return $this->redirect(['heritage', 'id' => $heritage->id]);	
            	}
       		}
        }

        return $this->render('create', [
        	'heritage' => $heritage,
            'model' => $model,
        ]);
    }
	
	public function actionContent($id)
    {
    	$content = $this->_findContent($id);
    	
        return $this->render('content', [
        	'content' => $content,
            'models' => $content->media,
        ]);
    }
	
    public function actionCreateContentMedia($id)
    {
    	$content = $this->_findContent($id);
        $model = new Media();
        $model->content_id = $content->id;
        
        $post = Yii::$app->request->post();
		if ($model->load($post))
        {
        	if ($model->validateTranslations() && $model->validate())
        	{
        		$model->createThumbs(Yii::getAlias('@frontend/web/img/'));
        		
        		if ($model->save(false) && $model->saveTranslations())
        		{
        			Yii::$app->getSession()->setFlash(
        				'success',
        				'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
        			);
        			return $this->redirect(['content', 'id' => $content->id]);	
            	}
       		}
        }

        return $this->render('create', [
        	'content' => $content,
            'model' => $model,
        ]);
    }
	
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
		if ($model->load($post))
        {
        	if ($model->validateTranslations() && $model->validate())
        	{
        		$model->createThumbs(Yii::getAlias('@frontend/web/img/'));
        		
        		if ($model->save(false) && $model->saveTranslations())
        		{
        			Yii::$app->getSession()->setFlash(
        				'success',
        				'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
        			);
        			$contentType = $model->contentType;
        			return $this->redirect([$contentType, 'id' => $model->{$contentType}->id]);	
            	}
       		}
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }
	
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->removeThumbs();
        $model->delete();
        
		$contentType = $model->contentType;
		return $this->redirect([$contentType, 'id' => $model->{$contentType}->id]);	
    }
	
    protected function findModel($id)
    {
    	if (!empty($this->_heritage))
    		return $this->_heritage;
        
    	if (!empty($this->_content))
        	return $this->_content;
        
		if (($model = Media::findOne($id)) !== null)
		{
			switch ($model->contentType)
			{
				case 'heritage':
					$this->_heritage = $model;
					break;
				case 'content':
					$this->_content = $model;
					break;
				case 'page':
					$this->_page = $model;
					break;
			}
			
			return $model;
		}
		else
        	throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    private function _findHeritage($id)
    {
    	if (empty($this->_heritage))
    	{
    		if (($model = Heritage::findOne($id)) !== null)
    		{
    			$this->_heritage = $model;
				return $model;
			}
			
			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    	}
        else
			return $this->_heritage;
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
    
    private function _isHeritageOwnerOrAdmin($id)
    {   
    	$user = Yii::$app->user->identity;
    	
    	if ($user->isAdmin())
    	{
    		return true;
    	}
    	else
    	{
    		$heritage = $this->_findHeritage($id);
    		if ($heritage->id == $user->heritage_id)
    			return true;
    	}
    	
    	return false;
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
