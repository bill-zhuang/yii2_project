<?php
namespace api\controllers;

use Yii;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        return self::dataOut([]);
    }

    public function actionError()
    {
        return self::errorOut( '发生错误啦');
    }
}
