<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionAddAdmin()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->setPassword('123456');
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generatePasswordResetToken();
        $user->status = User::STATUS_ACTIVE;
        var_dump($user->save());
    }

}