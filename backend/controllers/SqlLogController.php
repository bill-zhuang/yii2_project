<?php

namespace backend\controllers;

use Yii;
use backend\models\SqlLog;
use backend\models\Search\SqlLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SqlLogController implements the CRUD actions for SqlLog model.
 */
class SqlLogController extends Controller
{
    /**
     * Lists all SqlLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new SqlLogSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /**
     * Finds the SqlLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SqlLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SqlLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
