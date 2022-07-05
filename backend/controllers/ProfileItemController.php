<?php

namespace backend\controllers;

use Yii;
use common\models\ProfileItem;
use common\models\Heritage;
use backend\models\ProfileItemSearch;
use backend\components\HelperController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * ProfileItemController implements the CRUD actions for ProfileItem model.
 */
class ProfileItemController extends HelperController
{
	private $_heritage;
	
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
						'roles' => ['@']
					],
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function ($rule, $action) {
                            return $this->_isHeritageOwnerOrAdmin(Yii::$app->request->get('id'));
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

    /**
     * Lists all ProfileItem models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $searchModel = new ProfileItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$searchModel->heritage_id = $id;
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'heritage' => $this->_heritage,
        ]);
    }

    /**
     * Displays a single ProfileItem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProfileItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProfileItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProfileItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing ProfileItem model.
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
     * Finds the ProfileItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProfileItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProfileItem::findOne($id)) !== null) {
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
    
    private function _isHeritageOwnerOrAdmin($id)
    {   
    	$heritage = $this->_findHeritage($id);
    	$user = Yii::$app->user->identity;
    	
    	if ($user->isAdmin())
    	{
    		return true;
    	}
    	else
    	{
    		if ($heritage->id == $user->heritage_id)
    			return true;
    	}
    	
    	return false;
    }
}
