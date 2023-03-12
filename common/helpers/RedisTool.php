<?php

namespace common\helpers;

use Predis\Client;
use yii\redis\Connection;

class RedisTool
{
    private static $instance;

    /**
     * @return Client
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $redisComponent = \Yii::$app->redis;
            if ($redisComponent instanceof Connection) {
                self::$instance = new Client([
                    'host' => $redisComponent->hostname,
                    'port' => $redisComponent->port,
                    'password' => $redisComponent->password,
                ]);
            }
        }

        return self::$instance;
    }

    public static function getByKey($key)
    {
        $val = RedisTool::getInstance()->get($key);
        return unserialize($val);
    }

    public static function delKeys(array $keys)
    {
        return self::getInstance()->del($keys);
    }
}