<?php

namespace backend\controllers;

use Yii;
use backend\models\CalendarEvent;
use backend\models\Search\CalendarEventSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalendarEventController implements the CRUD actions for CalendarEvent model.
 */
class CalendarEventController extends Controller
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
     * Lists all CalendarEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
        $params = Yii::$app->request->queryParams;
        $searchModel = new CalendarEventSearch();
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    public function actionCalendar()
    {
        return $this->render('calendar');
    }

    public function actionComponent()
    {
        $currentMonth = date('Y-m');
        $monthData = $this->fetchCalendarMonthData($currentMonth);

        return $this->render('component', ['monthData' => $monthData]);
    }

    public function actionCalendarMonth()
    {
        $month = Yii::$app->request->get("month");
        if (empty($month)) {
            $month = date('Y-m');
        }
        $monthData = $this->fetchCalendarMonthData($month);

        return $this->asJson([
            'code' => 0,
            'msg' => 'success',
            'data' => $monthData,
        ]);
    }

    /**
     * Creates a new CalendarEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CalendarEvent();

        if ($model->load(Yii::$app->request->post())) {
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
     * Updates an existing CalendarEvent model.
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
     * Deletes an existing CalendarEvent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        if (($model = $this->findModel($id)) !== null) {
            $model->status = CalendarEvent::STATUS_INVALID;
            $model->save();
        }

        if (Yii::$app->request->referrer && (strpos(Yii::$app->request->referrer, '/view') === false)) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the CalendarEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CalendarEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CalendarEvent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function fetchCalendarMonthData($month)
    {
        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));
        $start = date('Y-m-d', strtotime($start . ' - 6 days'));
        $end = date('Y-m-d', strtotime($end . ' + 6 days'));
        $dbData = (new CalendarEvent())->startEndData($start, $end);
        $monthData = [];
        foreach ($dbData as $idx => $value) {
            $monthData[$idx]['title'] = $value['event'];
            $monthData[$idx]['start'] = $value['start_date'] . 'T' . $value['start_time'] . ':00';
            $monthData[$idx]['end'] = $value['end_date'] . 'T' . $value['end_time'] . ':00';
        }

        return $monthData;
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
