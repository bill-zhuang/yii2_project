<?php

namespace console\controllers;

use console\models\SqlLog;
use yii\console\Controller;

class SqlLogSynController extends Controller
{
    public function actionDo()
    {
        $day = date('Y-m-d', strtotime(' - 1 day'));
        $this->loopDoDate($day);
    }

    public function actionHistory($doDate = '')
    {
        if (empty($doDate)) {
            $doDate = date('Y-m-d');
        }
        $this->loopDoDate($doDate);
    }

    protected function loopDoDate($doDate)
    {
        for ($i = 0; ; $i++) {
            $postFix = '';
            if ($i != 0) {//log文件大小超限后 以原有文件名+'.数字'生成
                $postFix = ".{$i}";
            }
            $filePath = \Yii::getalias('@backend/runtime/logs/bk_sql_' . $doDate . '.log' . $postFix);
            if (!file_exists($filePath)) {
                break;
            }
            $this->synLogByDate($filePath);
        }
    }

    protected function synLogByDate($filePath)
    {
        //$filePath = \Yii::getalias('@backend/runtime/logs/bk_sql_' . $date . '.log');
        if (!file_exists($filePath)) {
            echo 'log file not exist. ' . $filePath;
        }
        $handle = fopen($filePath, 'r');
        if ($handle !== false) {
            while (($buffer = fgets($handle)) !== false) {
                if (strpos($buffer, '[yii\db\Command::execute]') === false) {
                    continue;
                }
                $sqlTime = substr($buffer, 0 , 19); //2020-10-21 14:13:13
                $sqlStamp = strtotime($sqlTime);
                //
                $split = explode('[yii\db\Command::execute]', $buffer);
                if (count($split) == 2) {
                    $subSplit = explode('][', $split[0]);
                    $ipaddr = explode('[', $subSplit[0])[1];
                    $bkUrid = str_replace('urid:', '', $subSplit[2]);
                    (new SqlLog())->addOne($bkUrid, $ipaddr, '', $subSplit[1],
                        '[' . $subSplit[3] . '[yii\db\Command::execute]', $split[1] ,$sqlStamp);
                } else {
                    $bkUrid = 0;
                    $pregBkUrid = '/\[urid:(\d+)\]/';
                    $matchFlag = preg_match($pregBkUrid, $buffer, $matches);
                    if ($matchFlag) {
                        $bkUrid = $matches[1];
                    }
                    (new SqlLog())->addOne($bkUrid, '', '','', '', $buffer ,$sqlStamp);
                }
                //echo var_dump($buffer) . PHP_EOL;
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }
    }

}