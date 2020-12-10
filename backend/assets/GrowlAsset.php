<?php


namespace backend\assets;


use yii\web\AssetBundle;

class GrowlAsset extends AssetBundle
{
    public $sourcePath = '@vendor/mouse0270/bootstrap-growl/dist';
    //public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'bootstrap-notify.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}