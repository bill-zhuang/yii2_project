<?php

namespace backend\controllers;

use backend\models\Search\ZhihuSaltSearch;
use Yii;
use backend\models\Search\ZhihuHotCollectionSearch;
use yii\web\Controller;

class ZhihuController extends BkController
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
    public function actionHotCollection()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new ZhihuHotCollectionSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('hot-collection', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /**
     * Lists all ZhihuHotCollection models.
     * @return mixed
     */
    public function actionHotCollectionScroll()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new ZhihuHotCollectionSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('hot-collection-scroll', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /**
     * Lists all ZhihuSalt models.
     * @return mixed
     */
    public function actionSalt()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new ZhihuSaltSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('salt', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /**
     * Lists all ZhihuSalt models.
     * @return mixed
     */
    public function actionSaltScroll()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new ZhihuSaltSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('salt-scroll', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }
}
