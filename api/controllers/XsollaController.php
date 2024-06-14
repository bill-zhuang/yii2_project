<?php


namespace api\controllers;
use Yii;
use yii\web\Response;

class XsollaController extends Controller
{
    private static $errorList = array(
        'errorUser' => array('code' => 'INVALID_USER', 'message' => 'error user',),
        'errorOrder' => array('code' => 'INVALID_PARAMETER', 'message' => 'error order',),
        'errorOrderUser' => array('code' => 'INVALID_PARAMETER', 'message' => 'error order user not match',),
        'errorNotificationType' => array('code' => 'INVALID_PARAMETER', 'message' => 'error notification type',),
        'errorSign' => array('code' => 'INVALID_SIGNATURE', 'message' => 'error signae',),
    );

    public function actionWebHook()
    {
        $headers = Yii::$app->getRequest()->getHeaders();
        $auth = $headers->get('Authorization');
        //$sandbox = (YII_ENV != YII_ENV_PROD);
        $postStr =file_get_contents('php://input');
        $post = json_decode($postStr, true);
        $auth = explode(' ', $auth);
        if (isset($auth[1])) {
            $confXsolla = Yii::$app->params['xsolla'];
            $encryptSign = sha1($postStr . $confXsolla['sign_key']);
            if ($encryptSign != $auth[1]) {
                return $this->error400(self::$errorList['errorSign']);
            }
        } else {
            return $this->error400(self::$errorList['errorSign']);
        }

        $notificationType = $post['notification_type'];
        if ($notificationType == 'user_validation') {
            return $this->triggerUserValidation($post);
        } elseif ($notificationType == 'payment') {
            return $this->triggerPayment($post);
        } elseif ($notificationType == 'order_paid') {
            return $this->triggerOrderPaid($post);
        } elseif ($notificationType == 'refund') {
            return $this->triggerRefund($post);
        } else {
            return $this->error400(self::$errorList['errorNotificationType']);
        }
    }

    //https://developers.xsolla.com/zh/webhooks/operation/user-validation/
    private function triggerUserValidation(array $post)
    {
        $notificationType = $post['notification_type'];
        $user = $post['user'];
        if ($notificationType == 'user_validation') {
            return $this->error400(self::$errorList['errorNotificationType']);
        }
        $userId = isset($user['id']) ? $user['id'] : 0;
        //todo valid user
        $isValidUser = false;
        if ($isValidUser) {
            $response = Yii::$app->response;
            $response->statusCode = 204;
            return $response->send();
        }
        //
        return $this->error400(self::$errorList['errorUser']);
    }

    private function triggerPayment(array $post)
    {
        $notificationType = $post['notification_type'];
        $user = $post['user'];
        $transaction = $post['transaction'];
        if ($notificationType == 'payment') {
            return $this->error400(self::$errorList['errorNotificationType']);
        }
        $userId = isset($user['id']) ? $user['id'] : 0;
        $transactionID = isset($transaction['external_id']) ? $transaction['external_id'] : '';
        $xsollaOrderID = isset($transaction['id']) ? $transaction['id'] : '';
        //todo check order info
        $orderInfo = [];
        if (isset($orderInfo['user_id']) && ($orderInfo['user_id'] == $userId)) {
            if ($orderInfo['status'] == 1) {
                $response = Yii::$app->response;
                $response->statusCode = 204;
                return $response->send();
            }
            //todo process order
            $processData = [];
            if ($processData['result']) {
                $response = Yii::$app->response;
                $response->statusCode = 204;
                return $response->send();
            } else {
                $error = self::$errorList['errorOrder'];
            }
        } else {
            $error = self::$errorList['errorOrderUser'];
        }
        //
        return $this->error400($error);
    }

    private function triggerOrderPaid(array $post)
    {
        $notificationType = $post['notification_type'];
        $user = $post['user'];
        $transaction = $post['order'];
        if ($notificationType == 'order_paid') {
            $this->error400(self::$errorList['errorNotificationType']);
        }
        $userId = isset($user['external_id']) ? $user['external_id'] : 0;
        $transactionID = isset($transaction['id']) ? $transaction['id'] : '';
        //todo check order
        $orderInfo = [];
        if (isset($orderInfo['user_id']) && ($orderInfo['user_id'] == $userId)) {
            return;
        }
        //
        return $this->error400(self::$errorList['errorOrderUser']);
    }

    private function triggerRefund(array $post)
    {
        $notificationType = $post['notification_type'];
        $user = $post['user'];
        $transaction = $post['transaction'];
        if ($notificationType == 'refund') {
            return $this->error400(self::$errorList['errorNotificationType']);
        }
        $userId = isset($user['id']) ? $user['id'] : 0;
        $transactionID = isset($transaction['external_id']) ? $transaction['external_id'] : '';
        //todo check order
        $orderInfo = [];
        if (isset($orderInfo['user_id']) && ($orderInfo['user_id'] == $userId)) {
            //sub gold
            if ($orderInfo['status'] == 1) {//已支付
                //todo refund order
            }
            //
            $response = Yii::$app->response;
            $response->statusCode = 204;
            return $response->send();
        }
        //
        return $this->error400(self::$errorList['errorOrderUser']);
    }

    private function error400($error)
    {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = ['error' => $error];
        $response->statusCode = 400;
        return $response->send();
    }
}