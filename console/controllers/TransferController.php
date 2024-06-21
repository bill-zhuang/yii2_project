<?php


namespace console\controllers;


use yii\console\Controller;
use yii\db\Connection;
use Yii;

class TransferController extends Controller
{
    public function actionDoBackup($startDate = '')
    {
        $this->transferSqlite2Mysql($startDate);
    }

    public function actionDo2App()
    {
        $this->transferMysql2Sqlite();
    }

    private function transferSqlite2Mysql($startDate)
    {
        //extension=pdo_sqlite 打开
        /* 数据库配置样例
        'sqlite_yii2' => array(
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:C:/Users/zstu_/yii2-20240301212509.db',
        ),
        'sqlite_2_mysql' => array(
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ),
         * */
        $sqliteDriver = Yii::$app->sqlite_yii2;
        $sqlite2MysqlDriver = Yii::$app->sqlite_2_mysql;
        if (!($sqliteDriver instanceof Connection)) {
            echo 'sqlite driver failed.' . PHP_EOL;
            exit;
        }
        if (!($sqlite2MysqlDriver instanceof Connection)) {
            echo 'sqlite to mysql driver failed.' . PHP_EOL;
            exit;
        }
        //
        $tblName = 'grain_recycle_history';
        $sql = 'select * from ' . $tblName;
        if (!empty($startDate)) {
            $sql .= " where happen_date>='{$startDate}'";
        }
        $grainData = $sqliteDriver->createCommand($sql)->queryAll();
        foreach ($grainData as $grainVal) {
            unset($grainVal['grhid']);
            $querySql = "select * from {$tblName} where happen_date='{$grainVal['happen_date']}'";
            $exist = $sqlite2MysqlDriver->createCommand($querySql)->queryOne();
            if (empty($exist)) {
                $sqlite2MysqlDriver->createCommand()->insert($tblName, $grainVal)->execute();
            }
        }
        //
        $tblName = 'eject_history';
        $sql = 'select * from ' . $tblName;
        if (!empty($startDate)) {
            $sql .= " where happen_date>='{$startDate}'";
        }
        $ejectData = $sqliteDriver->createCommand($sql)->queryAll();
        foreach ($ejectData as $ejectVal) {
            unset($ejectVal['ehid']);
            $querySql = "select * from {$tblName} where happen_date='{$ejectVal['happen_date']}' and type={$ejectVal['type']}";
            $exist = $sqlite2MysqlDriver->createCommand($querySql)->queryOne();
            if (empty($exist)) {
                $sqlite2MysqlDriver->createCommand()->insert($tblName, $ejectVal)->execute();
            }
        }
        //
        $tblName = 'finance_payment';
        $sql = 'select * from ' . $tblName;
        if (!empty($startDate)) {
            $sql .= " where payment_date>='{$startDate}'";
        }
        $paymentData = $sqliteDriver->createCommand($sql)->queryAll();
        foreach ($paymentData as $paymentVal) {
            $oldFpid = $paymentVal['fpid'];
            //
            unset($paymentVal['fpid']);
            $sqlite2MysqlDriver->createCommand()->insert($tblName, $paymentVal)->execute();
            $newFpid = $sqlite2MysqlDriver->getLastInsertID();
            if ($newFpid == 0) {
                echo 'insert payment failed.' . PHP_EOL;
                continue;
            }
            //
            $subTblName = 'finance_payment_map';
            $subSql = "select * from {$subTblName} where fpid=" . $oldFpid;
            $mapData = $sqliteDriver->createCommand($subSql)->queryAll();
            foreach ($mapData as $mapVal) {
                $mapVal['fpid'] = $newFpid;
                unset($mapVal['fpmid']);
                $sqlite2MysqlDriver->createCommand()->insert($subTblName, $mapVal)->execute();
            }
        }
        //
        $tblName = 'note';
        $sql = 'select * from ' . $tblName;
        if (!empty($startDate)) {
            $sql .= " where create_time>='{$startDate} 00:00:00'";
        }
        $noteData = $sqliteDriver->createCommand($sql)->queryAll();
        foreach ($noteData as $noteVal) {
            unset($noteVal['nid']);
            $querySql = "select * from {$tblName} where create_time='{$noteVal['create_time']}'";
            $exist = $sqlite2MysqlDriver->createCommand($querySql)->queryOne();
            if (empty($exist)) {
                $sqlite2MysqlDriver->createCommand()->insert($tblName, $noteVal)->execute();
            }
        }
    }

    private function transferMysql2Sqlite()
    {
        $sqliteDriver = Yii::$app->sqlite_yii2;
        $sqlite2MysqlDriver = Yii::$app->sqlite_2_mysql;
        if (!($sqliteDriver instanceof Connection)) {
            echo 'sqlite driver failed.' . PHP_EOL;
            exit;
        }
        if (!($sqlite2MysqlDriver instanceof Connection)) {
            echo 'sqlite to mysql driver failed.' . PHP_EOL;
            exit;
        }
        //clear db 主键id自增剔除!!!!
        $sqliteDriver->createCommand()->delete('sqlite_sequence')->execute();
        //clear db
        $sqliteDriver->createCommand()->delete('grain_recycle_history')->execute();
        $sqliteDriver->createCommand()->delete('eject_history')->execute();
        $sqliteDriver->createCommand()->delete('finance_category')->execute();
        $sqliteDriver->createCommand()->delete('finance_payment')->execute();
        $sqliteDriver->createCommand()->delete('finance_payment_map')->execute();
        $sqliteDriver->createCommand()->delete('note')->execute();
        //
        $tblName = 'finance_category';
        $sql = 'select * from ' . $tblName;
        $categoryData = $sqlite2MysqlDriver->createCommand($sql)->queryAll();
        foreach ($categoryData as $categoryVal) {
            $sqliteDriver->createCommand()->insert($tblName, $categoryVal)->execute();
        }
        //
        $tblName = 'finance_payment';
        $sql = 'select * from ' . $tblName;
        $paymentData = $sqlite2MysqlDriver->createCommand($sql)->queryAll();
        foreach ($paymentData as $paymentVal) {
            $oldFpid = $paymentVal['fpid'];
            $sqliteDriver->createCommand()->insert($tblName, $paymentVal)->execute();
            //
            $subTblName = 'finance_payment_map';
            $subSql = "select * from {$subTblName} where fpid=" . $oldFpid;
            $mapData = $sqlite2MysqlDriver->createCommand($subSql)->queryAll();
            foreach ($mapData as $mapVal) {
                $sqliteDriver->createCommand()->insert($subTblName, $mapVal)->execute();
            }
        }
        //
        $tblName = 'grain_recycle_history';
        $sql = 'select * from ' . $tblName;
        $grainData = $sqlite2MysqlDriver->createCommand($sql)->queryAll();
        foreach ($grainData as $grainVal) {
            $sqliteDriver->createCommand()->insert($tblName, $grainVal)->execute();
        }
        //
        $tblName = 'eject_history';
        $sql = 'select * from ' . $tblName;
        $ejectData = $sqlite2MysqlDriver->createCommand($sql)->queryAll();
        foreach ($ejectData as $ejectVal) {
            $sqliteDriver->createCommand()->insert($tblName, $ejectVal)->execute();
        }
        //
        $tblName = 'note';
        $sql = 'select * from ' . $tblName;
        $noteData = $sqlite2MysqlDriver->createCommand($sql)->queryAll();
        foreach ($noteData as $noteVal) {
            $sqliteDriver->createCommand()->insert($tblName, $noteVal)->execute();
        }
    }
}