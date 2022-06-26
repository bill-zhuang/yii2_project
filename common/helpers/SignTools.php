<?php

namespace common\helpers;

use Yii;

class SignTools
{
    public static function processHeaders(array $headers)
    {
        $ret = [
            'auth_type' => '',
            'auth_token' => '',
            'timestamp' => '',
            'nonce_str' => '',
            'sign' => '',
            'app_id' => '',
        ];
        if (!isset($headers['Authorization'])) {
            return $ret;
        }
        $headerAuthorization = $headers['Authorization'];
        $splitAuth = explode(' ', $headerAuthorization);
        if (isset($splitAuth[0])) {
            $ret['auth_type'] = $splitAuth[0];
        }
        $ret['auth_token'] = isset($splitAuth[1]) ? $splitAuth[1] : '';
        //
        $authArr = explode(',', $ret['auth_token']);
        foreach ($authArr as $val) {
            if (substr($val, 0, 10) == 'signature=') {//签名里面可能有=，只能单独处理
                $ret['sign'] = substr($val, 10);
                continue;
            }
            $split = explode('=', $val);
            if (count($split) != 2) {
                continue;
            }
            if ($split[0] == 'nonce_str') {
                $ret['nonce_str'] = $split[1];
            } elseif ($split[0] == 'app_id') {
                $ret['app_id'] = $split[1];
            } elseif ($split[0] == 'timestamp') {
                $ret['timestamp'] = $split[1];
            }
        }

        return $ret;
    }

    public static function encryptStr($privateKey, $method, $url, $stamp, $nonstr, $body)
    {
        $signStr = $method . "\n"
            . $url . "\n"
            . $stamp . "\n"
            . $nonstr . "\n"
            . $body . "\n";

        $res = openssl_sign($signStr, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        //openssl_free_key($privateKey);
        if ($res) {
            return base64_encode($signature);
        } else {
            throw new \Exception("String Sign Failed", 10004);
        }
    }

    public static function verifyRequestSign($publicKey, $signature, $method, $url, $headerStamp, $headerNonstr, $body)
    {
        $str = $method . "\n"
            . $url . "\n"
            . $headerStamp . "\n"
            . $headerNonstr . "\n"
            . $body . "\n";
        $signature = base64_decode($signature);
        $res = openssl_verify($str, $signature, $publicKey, OPENSSL_ALGO_SHA256);
        //
        return $res === 1 ? true : false;
    }

    public static function verifySign($publicKey, $signature, $headerStamp, $headerNonstr, $body)
    {
        $str = $headerStamp . "\n" .
            $headerNonstr . "\n" .
            $body . "\n";

        $signature = base64_decode($signature);
        $res = openssl_verify($str, $signature, $publicKey, OPENSSL_ALGO_SHA256);
        //
        return $res === 1 ? true : false;
    }

    public static function getNonstr($length = 32)
    {
        $chars = "123456123456789071234567890890";
        $chars .= "abcdefghijklmn123opq45rs67tuv89wxyz"; // if you need alphabatic also
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }
}