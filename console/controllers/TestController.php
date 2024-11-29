<?php

namespace console\controllers;

use common\helpers\MpegAudio;
use common\models\User;
use Yii;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionGii()
    {
        $tablePrefix = '';
        $tableNames = [

        ];
        $params = [
            '--tableName' => '',
            '--ns' => 'common\\models',
            '--modelClass' => '',
            '--useTablePrefix' => 1,
            '--overwrite' => 1,
            '--generateLabelsFromComments' => 1,
        ];
        foreach ($tableNames as $name) {
            $params['--tableName'] = $name;
            $name = str_replace($tablePrefix, '', $name);
            $modelName = $modelName = implode('', array_map('ucfirst', explode('_', $name)));
            $params['--modelClass'] = $modelName;
            Yii::$app->runAction('gii/model', $params);
        }
    }

    public function actionAudioTest()
    {
        $path = '';
        if (file_exists($path)) {
            $duration = MpegAudio::fromFile($path)->getTotalDuration();
            //MpegAudio::fromFile($path)->stripTags(); //移除所有tags 包括创作者，相册等
            MpegAudio::fromFile($path)->stripTags()->trim(15, $duration - 15)
                ->saveFile('newpath.mp3');
        }
    }
}