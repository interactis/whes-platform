<?php
namespace api\modules\v1\controllers;

use api\modules\v1\components\ApiController;

/**
 * Site controller
 */
class SiteController extends ApiController
{

	public function actionIndex()
    {
       $this->returnSuccess([], 200);
    }
    
    public function actionError()
    {
       $this->returnError(404);
    }
}
