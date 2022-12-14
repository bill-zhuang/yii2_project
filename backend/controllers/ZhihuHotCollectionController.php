<?php

namespace backend\controllers;

use Yii;
use backend\models\ZhihuHotCollection;
use backend\models\Search\ZhihuHotCollectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ZhihuHotCollectionController implements the CRUD actions for ZhihuHotCollection model.
 */
class ZhihuHotCollectionController extends Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    //"imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@webroot"),
                ],
            ]
        ];
    }

    /**
     * Lists all ZhihuHotCollection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new ZhihuHotCollectionSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /**
     * Lists all ZhihuHotCollection models.
     * @return mixed
     */
    public function actionIndexScroll()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new ZhihuHotCollectionSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('index-scroll', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /**
     * Finds the ZhihuHotCollection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZhihuHotCollection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZhihuHotCollection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function saveDuplicateAction($id)
    {
        $ckOption = Yii::$app->request->post('ckOption');
        if ($ckOption == 'view') {
            return $this->redirect(['view', 'id' => $id]);
        } elseif ($ckOption == 'create') {
            return $this->redirect(['create']);
        } elseif ($ckOption == 'update') {
            return $this->redirect(['update', 'id' => $id]);
        } else {
            return $this->redirect(['view', 'id' => $id]);
        }
    }
}
