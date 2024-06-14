<?php


namespace common\helpers;

use Yii;

class AliSms
{
    public static function sendSms($mobile, $code)
    {
        $paramsSms = Yii::$app->params['aliyun_sms'];
        $templateCode = $paramsSms['templateCode'];
        $signName = $paramsSms['signName'];
        $accessKey = $paramsSms['accessKeyId'];
        $accessSecret = $paramsSms['accessKeySecret'];
        $params = array(
            'PhoneNumbers' => $mobile,
            'SignName' => $signName,
            'TemplateCode' => $templateCode,
            'TemplateParam' => '{"code":"' . $code . '"}', //code加双引号，不然首数字为0会自动剔除
            //
            'Format' => 'JSON',
            'Version' => '2017-05-25',
            'AccessKeyId' => $accessKey,
            'SignatureVersion' => '1.0',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => uniqid(),
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'Action' => 'SendSms',
        );
        $params['Signature'] = self::computeSignature($params, $accessSecret);

        $url = 'http://dysmsapi.aliyuncs.com/?' . http_build_query($params);

        return CurlTools::getCurl($url);
    }

    private static function computeSignature($parameters, $accessKeySecret)
    {
        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQueryString .= '&' . self::percentEncode($key) . '=' . self::percentEncode($value);
        }
        $stringToSign = 'GET&%2F&' . self::percentencode(substr($canonicalizedQueryString, 1));
        return base64_encode(hash_hmac('sha1', $stringToSign, $accessKeySecret . '&', true));
    }

    private static function percentEncode($string)
    {
        $string = urlencode($string);
        $string = preg_replace('/\+/', '%20', $string);
        $string = preg_replace('/\*/', '%2A', $string);
        $string = preg_replace('/%7E/', '~', $string);
        return $string;
    }
}