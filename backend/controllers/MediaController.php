<?php

namespace backend\controllers;

use Yii;
use common\models\Media;
use common\models\Heritage;
use common\models\Content;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MediaController implements the CRUD actions for Media model.
 */
class MediaController extends Controller
{
	private $_model;
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
                        'actions' => ['update-heritage-media', 'update-content-media', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                        	if (Yii::$app->request->get('id') !== null)
    							$id = Yii::$app->request->get('id');
    						
    						if (Yii::$app->request->post('id') !== null)
    							$id = Yii::$app->request->post('id');
    						
                            $model = $this->findModel($id);
                            
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

        return $this->render('createHeritageMedia', [
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
        			$content->setQualityControl(false, $content->approved, true);
        			
        			Yii::$app->getSession()->setFlash(
        				'success',
        				'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
        			);
        			return $this->redirect(['content', 'id' => $content->id]);	
            	}
       		}
        }

        return $this->render('createContentMedia', [
        	'content' => $content,
            'model' => $model,
        ]);
    }
	
	public function actionUpdateHeritageMedia($id)
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
        			return $this->redirect(['heritage', 'id' => $model->heritage_id]);	
            	}
       		}
        }

        return $this->render('updateHeritageMedia', [
            'model' => $model
        ]);
    }
	
    public function actionUpdateContentMedia($id)
    {
        $model = $this->findModel($id);
		$content = $model->content;
		
        $post = Yii::$app->request->post();
		if ($model->load($post))
        {
        	if ($model->validateTranslations() && $model->validate())
        	{
        		$model->createThumbs(Yii::getAlias('@frontend/web/img/'));
        		
        		if ($model->save(false) && $model->saveTranslations())
        		{
        			$content->setQualityControl(false, $content->approved, true);
        			
        			Yii::$app->getSession()->setFlash(
        				'success',
        				'<span class="glyphicon glyphicon-ok-sign"></span> Your changes have been saved.'
        			);
        			return $this->redirect(['content', 'id' => $model->content_id]);	
            	}
       		}
        }

        return $this->render('updateContentMedia', [
            'content' => $content,
            'model' => $model
        ]);
    }
	
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->removeThumbs();
        $model->delete();
        
        $contentType = $model->contentType;
		if ($contentType == 'content')
		{
			$content = $model->{$contentType};
			$content->setQualityControl(false, $content->approved, true);
			return $this->redirect([$contentType, 'id' => $content->id]);
		}
		
		return $this->redirect([$contentType, 'id' => $model->{$contentType}->id]);
    }
	
    protected function findModel($id)
    {
    	if (!empty($this->_model))
    		return $this->_model;
        
		if (($model = Media::findOne($id)) !== null)
		{
			switch ($model->contentType)
			{
				case 'heritage':
					$this->_heritage = $model->heritage;
					break;
				case 'content':
					$this->_content = $model->content;
					break;
				case 'page':
					$this->_page = $model->page;
					break;
			}
			
			$this->_model = $model;
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
