<?php

namespace common\helpers;

use Yii;

class Utils
{
    public static function makeToken($n = 32)
    {
        return Yii::$app->security->generateRandomString($n);
    }

    public static function makeOrderNo($prefix = 'ORDER')
    {
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
}