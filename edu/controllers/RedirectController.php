<?php
namespace edu\controllers;

use Yii;
use yii\web\Controller;
use common\models\Article;
use common\models\Poi;
use common\models\Route;
use yii\web\NotFoundHttpException;

/**
 * Redirect controller for myswissalps.ch forwarding
 */
class RedirectController extends Controller
{
	public function actionArticle($id)
    {
    	if ($model = $this->findArticle($id))
    		$this->redirect(['article/view', 'slug' => $model->slug]);
    }
	
    public function actionPoi($id)
    {
    	if ($model = $this->findPoi($id))
    		$this->redirect(['poi/view', 'slug' => $model->slug]);
    }
    
    public function actionRoute($id)
    {
    	if ($model = $this->findRoute($id))
    		$this->redirect(['route/view', 'slug' => $model->slug]);
    }
    
    protected function findArticle($id)
    {    	
        $model = Article::find()
        	->joinWith('content')
			->where([
				'external_id' => $id,
				'published' => true,
				'archive' => false
			])->one();
		
		if ($model !== null)
		{
			 return $model;
		}
		else
			$this->redirect('https://ourheritage.ch/schweizer-alpen-jungfrau-aletsch');
    }
    
    protected function findPoi($id)
    {    	
        $model = Poi::find()
        	->joinWith('content')
			->where([
				'external_id' => $id,
				'published' => true,
				'archive' => false
			])->one();
		
		if ($model !== null)
            return $model;

        if ($model !== null)
		{
			 return $model;
		}
		else
			$this->redirect('https://ourheritage.ch/schweizer-alpen-jungfrau-aletsch');
    }
    
    protected function findRoute($id)
    {    	
        $model = Route::find()
        	->joinWith('content')
			->where([
				'external_id' => $id,
				'published' => true,
				'archive' => false
			])->one();
		
		if ($model !== null)
		{
			 return $model;
		}
		else
			$this->redirect('https://ourheritage.ch/schweizer-alpen-jungfrau-aletsch');
    }
}
