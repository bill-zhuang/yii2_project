<?php
namespace api\controllers;

use api\models\ZhihuHotCollection;
use common\models\ZhihuSalt;
use Yii;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        return self::dataOut([]);
    }

    public function actionError()
    {
        return self::errorOut( '发生错误啦');
    }

    public function actionZhihu()
    {
        $type = Yii::$app->request->get('type');
        $page = Yii::$app->request->get('page', 1);
        $limit = Yii::$app->request->get('limit', 20);

        if (empty($type) || (($type != 'hot') && ($type != 'salt'))) {
            return self::errorOut('error type.');
        }

        $offset = ($page - 1) * $limit;
        if ($type == 'hot') {
            $data = (new ZhihuHotCollection())->find()->asArray()
                ->offset($offset)->limit($limit)->all();
            return self::dataOut($data);
        } elseif ($type == 'salt') {
            $data = (new ZhihuSalt())->find()->asArray()
                ->offset($offset)->limit($limit)->all();
            return self::dataOut($data);
        } else {
            return self::errorOut('error type.');
        }
    }
}
