<?php
return [
    'aliyun_oss' => [
        'access_key' => '',
        'access_key_secret' => '',
        'bucket' => '',
        'end-point' => '',
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => null,
    ],
    'xsolla' => [
        'merchant_id' => '',
        'api_key' => '',
        'project_id' => '',
        'sign_key' => '',
        'pay_token_url' => 'https://store.xsolla.com/api/v3/project/%s/admin/payment/token',
        'sandbox_pay_url' => 'https://sandbox-secure.xsolla.com/paystation4/payment/3215?token=',
        'prod_pay_url' => 'https://secure.xsolla.com/paystation4/payment/3215?token=',
    ],
];
