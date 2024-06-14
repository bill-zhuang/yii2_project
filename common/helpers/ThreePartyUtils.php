<?php


namespace common\helpers;

use Yii;

class ThreePartyUtils
{
    /**
     * @param $identityToken
     * 样例 eyJraWQiOiJBSURPUEsxIiwiYWxnIjoiUlMyNTYifQ.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLnNreW1pbmcuYXBwbGVsb2dpbmRlbW8iLCJleHAiOjE1NjU2NjU1OTQsImlhdCI6MTU2NTY2NDk5NCwic3ViIjoiMDAwMjY2LmRiZTg2NWIwYWE3MjRlMWM4ODM5MDIwOWI5YzdkNjk1LjAyNTYiLCJhdF9oYXNoIjoiR0ZmODhlX1ptc0pqQ2VkZzJXem85ZyIsImF1dGhfdGltZSI6MTU2NTY2NDk2M30.J6XFWmbr0a1hkJszAKM2wevJF57yZt-MoyZNI9QF76dHfJvAmFO9_RP9-tz4pN4ua3BuSJpUbwzT2xFD_rBjsNWkU-ZhuSAONdAnCtK2Vbc2AYEH9n7lB2PnOE1mX5HwY-dI9dqS9AdU4S_CjzTGnvFqC9H5pt6LVoCF4N9dFfQnh2w7jQrjTic_JvbgJT5m7vLzRx-eRnlxQIifEsHDbudzi3yg7XC9OL9QBiTyHdCQvRdsyRLrewJT6QZmi6kEWrV9E21WPC6qJMsaIfGik44UgPOnNnjdxKPzxUAa-Lo1HAzvHcAX5i047T01ltqvHbtsJEZxAB6okmwco78JQA
     * @return bool|mixed
     */
    public static function appleIdentityTokenVerify($identityToken)
    {
        $appleKeys = CurlTools::getCurl('https://appleid.apple.com/auth/keys');
        $appleKeys = json_decode($appleKeys, true);
        //
        $split = explode('.', $identityToken);
        if (count($split) != 3) {//jwt 3段
            return false;
        }
        list($header, $payload, $sign) = $split;
        $decodePayload = json_decode(Utils::base64UrlDecode($payload), true);
        if (isset($decodePayload['iat']) && $decodePayload['iat'] > time()) {
            return false;
        }
        if (isset($decodePayload['exp']) && $decodePayload['exp'] < time()) {
            return false;
        }
        if (isset($decodePayload['nbf']) && $decodePayload['nbf'] > time()) {
            return false;
        }
        //
        $decodeHeader = json_decode(Utils::base64UrlDecode($header), true);
        foreach ($appleKeys['keys'] as $applePubInfo) {
            /*//debug
            $applePubInfo = [
                'kty' => 'RSA',
                'kid' => 'AIDOPK1',
                'use' => 'sig',
                'alg' => 'RS256',
                'e' => 'AQAB',
                'n' => "lxrwmuYSAsTfn-lUu4goZSXBD9ackM9OJuwUVQHmbZo6GW4Fu_auUdN5zI7Y1dEDfgt7m7QXWbHuMD01HLnD4eRtY-RNwCWdjNfEaY_esUPY3OVMrNDI15Ns13xspWS3q-13kdGv9jHI28P87RvMpjz_JCpQ5IM44oSyRnYtVJO-320SB8E2Bw92pmrenbp67KRUzTEVfGU4-obP5RZ09OxvCr1io4KJvEOjDJuuoClF66AT72WymtoMdwzUmhINjR0XSqK6H0MdWsjw7ysyd_JhmqX5CAaT9Pgi0J8lU_pcl215oANqjy7Ob-VMhug9eGyxAWVfu_1u6QJKePlE-w"
            ];*/
            if (($decodeHeader['alg'] == $applePubInfo['alg']) && ($decodeHeader['kid'] == $applePubInfo['kid'])) {
                //签名验证
                $pubKey = Utils::jwk2Pem($applePubInfo);
                if ($pubKey === false) {
                    return false;
                }
                $signDecode = Utils::base64UrlDecode($sign);
                $verify = Utils::verifyJwtSign($header . '.' . $payload, $signDecode, $pubKey, $applePubInfo['alg']);
                if ($verify) {
                    return $decodePayload;
                }
            }
        }

        return false;
    }

    public static function googleRefreshAccessToken($credentialJson, $refreshToken)
    {
        $clientInfo = self::googleGetClientInfo($credentialJson);
        $url = 'https://accounts.google.com/o/oauth2/token';
        $params = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $clientInfo['client_id'],
            'client_secret' => $clientInfo['client_secret'],
        );
        return CurlTools::postCurl($url, $params);
    }

    public static function googleVerifyPurchaseToken($packageName, $productId, $purchaseToken, $accessToken)
    {
        $url = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{packageName}/purchases/products/{productId}/tokens/{purchaseToken}';
        $url = str_replace(['{packageName}', '{productId}', '{purchaseToken}'], [$packageName, $productId, $purchaseToken], $url);
        $url .= '?access_token=' . $accessToken;
        return CurlTools::getCurl($url);
    }

    public static function googleVerifyIdToken($idToken)
    {
        $url = 'https://www.googleapis.com/oauth2/v3/userinfo?alt=json&id_token=' . $idToken;
        return CurlTools::getCurl($url);
    }

    public static function googleGetClientInfo($credentialJson)
    {
        $decode = json_decode($credentialJson, true);
        if (isset($decode['web'])) {
            return $decode['web'];
        }

        return array();
    }

    public static function xsollaPaymentUrl($userId, $productCode)
    {
        $mapCurrency = array( 'CN' => 'CNY', 'US' => 'USD', 'RU' => 'RUB', 'KZ' => 'KZT',);
        //todo get product info by $productCode & create order
        $productInfo = [];
        if (empty($productInfo['product'])) {
            return array('result' => 0, 'msg' => '订单创建失败');
        }
        $language = strtoupper($productInfo['product']['area']);
        $xsollaProduct = $productInfo['product']['xsolla_code'];
        $sandbox = (YII_ENV != YII_ENV_PROD);
        $xsollaParams = array(
            'purchase' => array(
                'items' => array(
                    array(
                        'quantity' => 1,
                        'sku' => $xsollaProduct,
                    ),
                ),
            ),
            'settings' => array(
                'currency' => $mapCurrency[$language],
                'external_id' => '',
                //'language' => '',
                //'payment_method' => '',
                'return_url' => !$sandbox ? 'todo prod url' : 'todo alpha url',
            ),
            'user' => array(
                'id' => array('value' => strval($userId)),
                'country' => array('value' => $language, "allow_modify" => true),
                //'phone' => array('value' => ''),
                //'steam_id' => array('value' => '17 bits \d{17}'),
                //'tracking_id' => array('value' => '32 bits [A-Za-z0-9]{32}'),
            ),
            'sandbox' => $sandbox,
        );

        $confXsolla = Yii::$app->params['xsolla'];
        $pwd = $confXsolla['merchant_id'] .':' . $confXsolla['api_key'];
        $url = sprintf($confXsolla['pay_token_url'], $confXsolla['project_id']);
        //todo create order
        $createRet = [];
        if ($createRet['result']) {
            $xsollaParams['settings']['external_id'] = $createRet['order_id'];
            $retJson = self::xsollaPayPost($url, $xsollaParams, $pwd);
            $retXsolla = json_decode($retJson, true);
            if (isset($retXsolla['order_id'])) {
                $payUrl = ($sandbox ? $confXsolla['sandbox_pay_url'] : $confXsolla['prod_pay_url']) . $retXsolla['token'];
                return array('result' => 1, 'url' => $payUrl);
            }
            return array('result' => 0, 'msg' => '支付链接生成失败');
        } else {
            return array('result' => 0, 'msg' => '订单创建失败');
        }
    }

    private static function xsollaPayPost($url, array $data, $password)
    {
        $data = json_encode($data);
        $header = array(
            'Content-Type: application/json'
        );
        $header[] = 'Authorization: Basic ' . base64_encode($password);
        //
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $return = curl_exec($ch);
        curl_close($ch);

        return $return;
    }
}