<?php

namespace common\helpers;

use Predis\Client;

class RedisTool
{
    private static $instance;

    /**
     * @return Client
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $redisParams = \Yii::$app->params['redis'];
            self::$instance = new Client([
                'host' => $redisParams['host'],
                'port' => $redisParams['port'],
                'password' => $redisParams['password'],
            ]);
        }

        return self::$instance;
    }
}