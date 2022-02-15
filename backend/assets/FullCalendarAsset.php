<?php


namespace backend\assets;


use yii\web\AssetBundle;

class FullCalendarAsset extends AssetBundle
{
    //@vendor/almasaeed2010/adminlte/bower_components/fullcalendar/dist
    //@webroot/fullcalendar
    public $sourcePath = '@webroot/fullcalendar';
    //public $baseUrl = '@web/fullcalendar';
    public $css = [
        'main.css',
        //'fullcalendar.css'
    ];
    public $js = [
        'main.js',
        'locales-all.js',
        //'fullcalendar.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}