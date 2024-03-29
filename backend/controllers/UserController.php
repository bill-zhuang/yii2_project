<?php

namespace backend\controllers;

use backend\models\SignupForm;
use common\helpers\Utils;
use Yii;
use backend\models\User;
use backend\models\Search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $model->isNew = true;

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $modelUser = $this->findModel($id);
        $model = new SignupForm();
        $model->isNew = false;
        if ($model->load(Yii::$app->request->post()) && $model->modifyInfo($id)) {
            return $this->redirect(['index']);
        } else {
            $model->username = $modelUser->username;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->deleteUser()) {
            Utils::setYiiFlash('success', '删除成功', false);
        } else {
            Utils::setYiiFlash('danger', '删除失败', false);
        }

        if (Yii::$app->request->referrer) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\Exception
     */
    public function actionModifyPassword()
    {
        $model = $this->findModel(Yii::$app->user->getIdentity()->getId());

        $postData = Yii::$app->request->post();
        if (isset($postData['ModifyForm']['old-password'])
            && isset($postData['ModifyForm']['new-password'])) {
            $old = $postData['ModifyForm']['old-password'];
            $new = $postData['ModifyForm']['new-password'];
            if ($model->validatePassword($old)) {
                if ($model->resetPassword($new)) {
                    Yii::$app->user->logout();
                    return $this->goHome();
                }
            }
        }

        return $this->render('modify-password', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
