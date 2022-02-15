<?php

namespace api\controllers;

use Yii;
use yii\base\Exception;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;

class Controller extends \yii\rest\Controller
{
    const MSG_SUCCESS = "成功";
    const MSG_PARAM_ERR = "参数错误";

    const SUCCESS = "200";
    const TOKEN_ERR = "201";
    const PARAM_ERR = "202";
    const OTHER_ERR = "203";

    public function __construct($id, $module, $config = array())
    {
        header('Access-Control-Allow-Origin: *');

        parent::__construct($id, $module, $config);
    }

    /**
     * Authentication 认证
     * https://www.cnblogs.com/ganiks/p/Yii2-RESTful-Authentication-and-Authorization.html
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                //这个地方使用`ComopositeAuth` 混合认证
                'class' => CompositeAuth::className(),
                //`authMethods` 中的每一个元素都应该是 一种 认证方式的类或者一个 配置数组
                'authMethods' => [
                    //HttpBasicAuth HTTP 认证机制仅在 PHP 以 Apache 模块方式运行时才有效，因此该功能不适用于 CGI 版本
                    //HttpBasicAuth::className(), //access token 作为一个用户名被传递
                    /*[
                        'class' => HttpBasicAuth::className(),
                        'auth' => function ($username, $password) {
                            $model = User::findByUsername($username);
                            if (($model->status == User::STATUS_ACTIVE) && $model->validatePassword($password)) {
                                return $model;
                            }
                            return null;
                        }
                    ],*/
                    HttpBearerAuth::className(), //遵照 OAth2.0 协议， 调用者从一个 授权服务器 上获取 access token， 再通过 HTTP Bearer Tokens 发送给 Api 服务器
                    /*[
                        'class' => HttpBearerAuth::className(),
                        'header' => 'Authorization', //对应的token字段名，默认为Authorization
                        'pattern' => '/^Bearer\s+(.*?)$/', //对应的token获取正则，默认为/^Bearer\s+(.*?)$/
                    ],*/
                    QueryParamAuth::className(), //access token 在 API URL 中作为一个查询参数被传递
                    /*[
                        'class' => QueryParamAuth::className(),
                        'tokenParam' => 'token' //对应的token字段名，默认为access-token
                    ],*/
                ]
            ]
        ]);
    }

    public static function dataOut(array $data, $code = self::SUCCESS, $message = self::MSG_SUCCESS)
    {
        if (empty($code)) {
            $code = self::OTHER_ERR;
        }
        $out_data['code'] = $code;
        $out_data['message'] = $message;
        $out_data['data'] = $data;
        $out_data['sys_time'] = time();
        return $out_data;
    }

    public static function errorOut($code = self::PARAM_ERR, $message = self::MSG_PARAM_ERR)
    {
        $out['code'] = $code;
        $out['message'] = $message;

        Yii::$app->response->data = $out;
        Yii::$app->end();
    }

    /**
     * 获取用户输入的数据
     * @return array|mixed
     */
    public static function requestData()
    {
        $data = new \stdClass();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $decode = json_decode($request->rawBody, true);
            if (is_array($decode)) {
                $data = $decode;
            } else {
                $data = $request->post();
            }
        } elseif ($request->isGet) {
            $data = $request->get();
        }

        return $data;
    }

    /**
     * @param $key
     * @param string $default
     * @return string
     */
    public static function getRequestParam($key, $default = null)
    {
        $requestData = self::requestData();
        return array_key_exists($key, $requestData) ? $requestData[$key] : $default;
    }

    /**
     * @param $key
     * @param string $default
     * @return string
     */
    public static function getRequestParamErr($key, $default = null)
    {
        $requestData = self::requestData();
        $value = array_key_exists($key, $requestData) ? $requestData[$key] : $default;

        if (empty($value)) {
            self::errorOut("{$key}错误");
        }
        return $value;
    }
}