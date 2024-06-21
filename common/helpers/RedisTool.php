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

    public static function setByKey($key, $value, $exp = 3600)
    {
        if (is_object($value) || is_array($value)) {
            $value = serialize($value);
        }
        return RedisTool::getInstance()->setex($key, $exp, $value);
    }

    public static function delKeys(array $keys)
    {
        return self::getInstance()->del($keys);
    }

    public static function getRankTop($key, $start, $end)
    {
        //第四个参数, array('withscores' => true) 返回 k => v
        return RedisTool::getInstance()->zrevrange($key, $start, $end);
    }

    public static function hashDel($key, array $id)
    {
        RedisTool::getInstance()->hdel($key, $id);
    }
}