<?php

namespace common\helpers;

class CurlTools
{
    public static function postCurl($url, $postData, $isJsonPost = false, array $headers = [])
    {
        $handle = curl_init();
        if ($handle === false) {
            return false;
        }
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $postData);
        if ($isJsonPost) {
            $headers[] = 'Content-Type: application/json';
        }
        if (!empty($headers)) {
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        }
        $output = curl_exec($handle);
        curl_close($handle);
        return $output;
    }

    public static function getCurl($url)
    {
        $handle = curl_init();
        if ($handle === false) {
            return false;
        }
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($handle);
        curl_close($handle);
        return $output;
    }
}