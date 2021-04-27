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
                        'actions' => ['page'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                        	$user = Yii::$app->user->identity;
                            return $user->isAdmin();
                        }
                    ],
                    [
                        'actions' => ['heritage'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->_isHeritageOwnerOrAdmin();
                        }
                    ],
                    [
                        'actions' => ['content'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->_isContentOwnerOrAdmin();
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
	
	public function actionPage($id)
    {
        return $this->render('index', [
            'model' => $this->findPageModels($id),
        ]);
    }
	
    public function actionHeritage($id)
    {
    	$heritage = $this->_findHeritage($id);
    	
        return $this->render('heritage', [
        	'model' => $heritage,
            'models' => $heritage->media,
        ]);
        
    }
    
    public function actionContent($id)
    {
    	$content = $this->_findContent($id);
    	
        return $this->render('index', [
            'models' => $content->media,
        ]);
    }
	
    public function actionCreateHeritageMedia()
    {
        $model = new Media();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
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
        if (($model = Media::findOne($id)) !== null) {
            return $model;
        }

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
    
    private function _isHeritageOwnerOrAdmin()
    {   
    	$user = Yii::$app->user->identity;
    	
    	if ($user->isAdmin())
    	{
    		return true;
    	}
    	else
    	{
    		$heritage = $this->_findHeritage(Yii::$app->request->get('id'));
    		if ($heritage->id == $user->heritage_id)
    			return true;
    	}
    	
    	return false;
    }
    
    private function _isContentOwnerOrAdmin()
    {   
    	$user = Yii::$app->user->identity;
    	
    	if ($user->isAdmin())
    	{
    		return true;
    	}
    	else
    	{
    		$content = $this->_findContent(Yii::$app->request->get('id'));
    		if ($content->heritage_id == $user->heritage_id)
    			return true;
    	}
    	
    	return false;
    }
}
