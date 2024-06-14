<?php

namespace common\helpers;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Math\BigInteger;
use Yii;

class Utils
{
    public static function setYiiFlash($key, $value = true, $removeAfterAccess = true)
    {
        Yii::$app->session->setFlash($key, $value, $removeAfterAccess);
    }

    public static function makeToken($n = 32)
    {
        return Yii::$app->security->generateRandomString($n);
    }

    public static function makeOrderNo($prefix = 'ORDER')
    {
        /*$timeStr = date('YmdHis');
        $timeStr = strval($timeStr + mt_rand(1, 10000));*/
        return $prefix . date('YmdHis') . mt_rand(10000, 99999)
            . substr(implode(null, array_map('ord',
                str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    //from stack overflow
    public static function makeCode($length = 16)
    {
        $random = "";
        srand((double) microtime() * 1000000);

        $data = "123456123456789071234567890890";
        $data .= "abcdefghijklmn123opq45rs67tuv89wxyz"; // if you need alphabatic also

        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }

        return $random;
    }

    public static function getIp()
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ipAddr = $_SERVER["HTTP_CLIENT_IP"];
        } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ipAddr = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (!empty($_SERVER["REMOTE_ADDR"])) {
            $ipAddr = $_SERVER["REMOTE_ADDR"];
        } else {
            $ipAddr = '';
        }
        preg_match("/[\d\.]{7,15}/", $ipAddr, $matches);
        $ip = isset($matches[0]) ? $matches[0] : 'unknown';

        return $ip;
    }

    public static function html2Excel($htmlContent, $filename)
    {
        // save $table inside temporary file that will be deleted later
        $tmpfile = tempnam(sys_get_temp_dir(), 'html');
        file_put_contents($tmpfile, $htmlContent);

        // insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
        $excelHTMLReader = \PHPExcel_IOFactory::createReader('HTML');
        $objPHPExcel = $excelHTMLReader->load($tmpfile);
        unlink($tmpfile); // delete temporary file because it isn't needed anymore

        // Creates a writer to output the $objPHPExcel's content
        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Cache-Control: max-age=0');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename='.$filename.'.xlsx');
        header("Content-Transfer-Encoding:binary");
        $writer->save('php://output');
    }

    public static function debugTrace()
    {
        $array = debug_backtrace();
        return $array;
        foreach ($array as $row) {
            var_dump($row['file'] . ':' . $row['line'] . '行,调用方法:' . $row['function']);
        }
    }

    public static function str2MultiArr()
    {
        //https://php.tutorialink.com/string-to-multidimensional-recursive-array-in-php/
        $strs = [
            'A_B1_C1' => 1,
            'A_B1_C2' => 2,
            'A_B2_C1_D3' => 3,
            'A_B2_C1_D4' => 4,
            'A_B2_C2' => 5,
        ];
        $arr = [];
        foreach ($strs as $item => $val) {
            $parts = explode('_', $item);
            //$last = array_pop($parts);
            $last = $val;

            // hold a reference of to follow the path
            $ref = &$arr;
            foreach ($parts as $part) {
                // maintain the reference to current path
                $ref = &$ref[$part];
            }
            // finally, store the value
            $ref = $last;
        }

        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public static function generatePubPriKey()
    {
        $config = array(
            //'config' => 'C:/soft/php-7.4.22/extras/ssl/openssl.cnf',//找到你的PHP目录下openssl配置文件
            'digest_alg' => 'sha512',
            'private_key_bits' => 1024,//指定多少位来生成私钥
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        );
        $res = openssl_pkey_new($config);
        //获取私钥
        openssl_pkey_export($res, $private_key, null, $config);
        //获取公钥
        $details = openssl_pkey_get_details($res);
        $public_key = $details['key'];

        return [
            'public_key' => $public_key,
            'private_key' => $private_key
        ];
    }

    public static function base64UrlEncode(string $input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    public static function base64UrlDecode(string $input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $addlen = 4 - $remainder;
            $input .= str_repeat('=', $addlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public static function verifyJwtSign(string $input, string $sign, string $key, string $alg = 'RS256')
    {
        $algConfig = array(
            'RS256' => 'SHA256'
        );
        if (!isset($algConfig[$alg])) {
            return false;
        }
        return openssl_verify($input, $sign, $key, 'SHA256' );
    }

    //返回类型必须带string 否则返回object对象
    public static function jwk2Pem(array $jwk) : string
    {
        return  PublicKeyLoader::load([
            'e' => new BigInteger(base64_decode($jwk['e']), 256),
            'n' => new BigInteger(self::base64UrlDecode($jwk['n']), 256)
        ]);
    }

    public static function postman2Md($postmanJsonPath, $outputMdPath)
    {
        $path = $postmanJsonPath;
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        $mdFile = $outputMdPath;
        $mdContent = <<<EOF
**接口文档**
---------------------------
######
EOF;
        $mdContent .= PHP_EOL;
        foreach ($data['item'] as $idx => $value) {
            $tempIdx = $idx + 1;
            $params = [];
            if (isset($value['request']['url']['query'])) {
                foreach ($value['request']['url']['query'] as $qVal) {
                    if ($qVal['key'] == 'gid') {
                        continue;
                    }
                    $params[] = $qVal['key'];
                }
            } elseif (isset($value['request']['body']['raw'])) {
                $rawData = json_decode($value['request']['body']['raw'], true);
                if (is_array($rawData)) {
                    $params = array_keys($rawData);
                    foreach ($params as $pIdx => $pVal) {
                        if ($pVal == 'gid') {
                            unset($params[$pIdx]);
                        }
                    }
                }
            }
            //print_r($params);
            $mdContent .= <<<EOF
**{$tempIdx}. {$value['name']}   {$value['request']['method']}**

|      字段         |   是否必填  |   参数值及说明              |
| ----------------- | ---------- | ------------------------- |
EOF;
            $mdContent .= PHP_EOL;
            foreach ($params as $pName) {
                $mdContent .= <<<EOF
| {$pName}            |    是      |                    |
EOF;
                $mdContent .= PHP_EOL;
            }

            $mdContent .= <<<EOF
返回数据为json

|      返回数据格式         |     参数值及说明              |
| ----------------------- | ---------------------------  |
|          code           | 错误码 : 200-成功 非200-失败   |
|          message        | 信息 : 成功,失败              |
|           data          | 数据                         |
|          sys_time       | 系统时间 unix时间戳           |

EOF;
            $mdContent .= PHP_EOL;
        }
        file_put_contents($mdFile, $mdContent);
    }

    public static function isValidJson($jsonStr)
    {
        json_decode($jsonStr, true);
        return (json_last_error() !== JSON_ERROR_NONE);
    }
}