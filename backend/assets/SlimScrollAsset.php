<?php


namespace backend\assets;


use yii\web\AssetBundle;

class SlimScrollAsset extends AssetBundle
{
    public $sourcePath = '@vendor/grimmlink/jquery-slimscroll';
    //public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'jquery.slimscroll.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}