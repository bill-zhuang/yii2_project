<?php

namespace backend\controllers;

use common\helpers\Utils;
use Yii;
use backend\models\ThirdAccount;
use backend\models\Search\ThirdAccountSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ThirdAccountController implements the CRUD actions for ThirdAccount model.
 */
class ThirdAccountController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ThirdAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
        $params = Yii::$app->request->queryParams;
        $searchModel = new ThirdAccountSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /**
     * Creates a new ThirdAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ThirdAccount();

        if ($model->load(Yii::$app->request->post())) {
            $keyPubPri = Utils::generatePubPriKey();
            $model->pub_key = $keyPubPri['public_key'];
            $model->pri_key = $keyPubPri['private_key'];
            $model->create_time = date('Y-m-d H:i:s');
            if ($model->save()) {
                $this->saveDuplicateAction($model->id);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ThirdAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->saveDuplicateAction($model->id);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ThirdAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        if (($model = $this->findModel($id)) !== null) {
            $model->status = ThirdAccount::STATUS_INVALID;
            $model->save();
        }

        if (Yii::$app->request->referrer && (strpos(Yii::$app->request->referrer, '/view') === false)) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionKeyDownload($id, $type)
    {
        if (($model = $this->findModel($id)) !== null) {
            $fileName = $type . '.txt';
            header('Cache-Control: max-age=0');
            header("Pragma: public");
            header("Expires: 0");
            header('Accept-Ranges: bytes');
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/text/plain");
            header("Content-Type:application/download");;
            header('Content-Disposition:attachment;filename=' . $fileName);
            header("Content-Transfer-Encoding:binary");
            if ($type == 'pub') {
                echo $model->pub_key;
            } elseif ($type == 'pri') {
                echo $model->pri_key;
            } else {
                echo '';
            }
        }

        exit;
    }

    /**
     * Finds the ThirdAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ThirdAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ThirdAccount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function saveDuplicateAction($id)
    {
        return $this->goBack();
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
