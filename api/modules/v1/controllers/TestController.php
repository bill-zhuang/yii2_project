<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
{
    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        return 1;
    }
}
