<?php
return [
    'aliases' => [
        //'@bower' => '@vendor/bower-asset',
        '@bower' => '@vendor/yidas/yii2-bower-asset/bower',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            //'class' => 'yii\redis\Cache', yii2_redis会将非规则key做md5!!!
        ],
    ],
    'language' => 'zh-CN'
];
