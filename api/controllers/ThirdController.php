<?php
namespace api\controllers;

use common\helpers\SignTools;
use common\models\ThirdAccount;
use Yii;

/**
 * Third controller
 */
class ThirdController extends Controller
{
    public function actionVerify()
    {
        if (!Yii::$app->request->isPost) {
            $response = \YII::$app->response;
            $response->statusCode = 401;
            return;
        }
        $headers = getallheaders();
        $processData = SignTools::processHeaders($headers);
        if ($processData['auth_type'] != 'XX-SHA256-RSA2048') {
            $response = \YII::$app->response;
            $response->statusCode = 401;
            return;
        }
        //
        $headerAppID = $processData['app_id'];
        $appID = Yii::$app->request->post("app_id");
        //todo other params
        if ($headerAppID != $appID) {
            $response = \YII::$app->response;
            $response->statusCode = 401;
            return;
        }
        //check appid
        $modelThirdAcc = ThirdAccount::findOne(['appid' => $appID, 'status' => 1]);
        if (!isset($modelThirdAcc)) {
            $response = \YII::$app->response;
            $response->statusCode = 401;
            return;
        }
        $publicKey = $modelThirdAcc->pub_key;
        //
        $params = self::requestData();
        $jsonParams = json_encode($params, JSON_UNESCAPED_UNICODE);
        $url = 'third/verify';
        $verifyRet = SignTools::verifyRequestSign($publicKey, $processData['sign'],
            'POST', $url, $processData['timestamp'], $processData['nonce_str'], $jsonParams);
        if (!$verifyRet) {
            $response = \YII::$app->response;
            $response->statusCode = 401;
            return;
        }

        //todo

        return;
    }
}
