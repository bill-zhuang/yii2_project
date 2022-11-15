<?php

namespace backend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class TemplateController extends Controller
{
    public function actionTabs()
    {
        $params = Yii::$app->request->queryParams;

        return $this->render('tabs', [
            'params' => $params,
        ]);
    }

    /*--------------------------------------------------------------------------*/

    public function actionFileInput()
    {
        $params = Yii::$app->request->queryParams;
        $dataProvider = new ArrayDataProvider();
        $dataProvider->allModels = [];
        $dataProvider->allModels = [
            ['id' => 1, 'url' => '/img/avatar.png"'],
            ['id' => 2, 'url' => '/img/avatar2.png"'],
            ['id' => 3, 'url' => '/img/avatar3.png"'],
            ['id' => 4, 'url' => '/img/avatar5.png"'],
        ];

        return $this->render('file_input', [
            'dataProvider'=> $dataProvider,
            'params' => $params,
        ]);
    }

    public function actionFileInputAjax()
    {
        \Yii::$app->response->format = Response::FORMAT_HTML;
        $imgObj = UploadedFile::getInstanceByName("avatar[0]");
        if(empty($imgObj)) {
            echo json_encode(['error' => '上传失败']);
            exit;
        }
        //upload operation
        $flag = true;
        //
        if ($flag) {
            //save db etc.
            echo json_encode(['id' => 11]);
            exit;
        }

        echo json_encode(['error' => '上传失败']);
        exit;
    }

    /*--------------------------------------------------------------------------*/

    public function actionExpandRow()
    {
        $params = Yii::$app->request->queryParams;

        $dataProvider = new ArrayDataProvider();
        $dataProvider->allModels = [
            'unique_id' => ['id' => 1, 'browser' => 'Firefox 1.0', 'platform' => 'Win 98+ / OSX.2+', 'engine' => '1.0'],
        ];

        return $this->render('expand_row', [
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    public function actionExpandRowDetail()
    {
        $dataProvider = new ArrayDataProvider();
        $dataProvider->allModels = [];
        if (isset($_POST['expandRowKey'])) {
            $uniqueID = $_POST['expandRowKey'];//这个值对应上面action的数组的key，自己设置，唯一
            $dataProvider->allModels = [
                ['id' => 1, 'browser' => 'Firefox 1.0', 'platform' => 'Win 98+ / OSX.2+', 'engine' => '1.0'],
            ];
            return $this->renderPartial('expand_row_detail', ['dataProvider'=> $dataProvider]);
        } else {
            return $this->renderPartial('expand_row_detail', ['dataProvider'=> $dataProvider]);
        }
    }

    /*--------------------------------------------------------------------------*/

    public function actionPjax()
    {
        $params = Yii::$app->request->queryParams;

        $dataProvider = new ArrayDataProvider();
        $dataProvider->allModels = [
            ['id' => 1, 'browser' => 'Firefox 1.0', 'platform' => 'Win 98+ / OSX.2+', 'engine' => '1.0'],
        ];

        return $this->render('pjax', [
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    public function actionPjaxSearch()
    {
        if (!Yii::$app->request->isPjax) {
            return $this->redirect('pjax');
        }

        $params = Yii::$app->request->queryParams;

        $dataProvider = new ArrayDataProvider();
        $dataModels = [];

        for ($i = 0; $i < rand(1, 5); $i++) {
            $dataModels[] = ['id' => 1, 'browser' => 'Chrome 1.0 ' . rand(0, 10000), 'platform' => 'Win 98+ / OSX.2+', 'engine' => '1.0'];
        }

        $dataProvider->allModels = $dataModels;

        return $this->render('pjax', [
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }

    /*--------------------------------------------------------------------------*/

    public function actionSelect2()
    {
        $params = Yii::$app->request->queryParams;

        return $this->render('select2', [
            'params' => $params,
        ]);
    }

    public function actionSelect2Ajax($q = null)
    {
        $out = ['results' => []];
        if (!is_null($q)) {
            $data = [
                ['id' => 1, 'browser' => 'Chrome 1.0', 'platform' => 'Win 98+ / OSX.2+', 'engine' => '1.0'],
            ];
            foreach ($data as $key => $value) {
                $out['results'][] = [
                    'id' => $value['id'],
                    'text' => $value['browser'],
                ];
            }
        }
        return $this->asJson($out);
    }

    /*--------------------------------------------------------------------------*/
}
