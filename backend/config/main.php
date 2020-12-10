<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => '@backend/views/layouts/main',
        ],
        'gridview'=>[
            'class' => 'kartik\grid\Module'
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            '*', //路由配置，权限后，注释!!!!
            'site/*',//允许访问的节点，可自行添加
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/bk_sql_' . date('Y-m-d') . '.log',
                    'logVars' => [],
                    'levels' => ['profile'],
                    'categories' => ['yii\db\Command::execute'],//'yii\db\Command::query',
                    'prefix' => function ($message) {
                        if (Yii::$app === null) {
                            return '';
                        }
                        $request = Yii::$app->getRequest();
                        $ip = $request instanceof \yii\web\Request ? $request->getUserIP() : '-';
                        $controller = Yii::$app->controller->id;
                        $action = Yii::$app->controller->action->id;
                        $urid = isset(Yii::$app->user) ? Yii::$app->user->getId() : 0;
                        return "[$ip][$controller/$action][urid:$urid]";
                    }
                ],
                /*[
                    'class' => 'notamedia\sentry\SentryTarget',
                    'levels' => ['error', 'warning'],
                    'dsn' => 'sentry-dsn',
                    'context' => true,
                ],*/
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
            //"defaultRoles" => ["guest"],
            'itemChildTable' => '{{%auth_item_child}}',
            'itemTable' => '{{%auth_item}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',
        ],
    ],
    'params' => $params,
];
