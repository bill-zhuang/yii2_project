<?php

namespace backend\controllers;

use Yii;
use backend\models\Letters;
use backend\models\Search\LettersSearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
//use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LettersController implements the CRUD actions for Letters model.
 */
class LettersController extends Controller
{
    /**
     * Lists all Letters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $limit = 30;
        $randLetters = (new Letters())->randLetter($params, $limit);
        $a = new ArrayDataProvider();
        $a->models = $randLetters;
        //$a->pagination->pageSize = $limit;
        $a->pagination = false;

        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('index_list', [
                'dataProvider' => $a,
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $a,
            'letters' => $randLetters,
            'params' => $params,
        ]);
    }

    public function actionPlus()
    {
        $flag = false;
        $id = Yii::$app->request->post('id');
        if ($id) {
            $model = Letters::findOne($id);
            if (isset($model)) {
                $model->err_cnt += 1;
                $flag = $model->save();
            }
        }
        return $this->asJson([
            'code' => $flag ? 0 : 1,
        ]);
    }
}
