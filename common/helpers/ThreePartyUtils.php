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
        $url = 'https://www.googleapis.com/oauth2/v3/userinfo?alt=json&access_token=' . $idToken;
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
}