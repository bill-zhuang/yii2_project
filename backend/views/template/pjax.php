<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $params array */

$this->title = 'Pjax';
$this->params['breadcrumbs'][] = $this->title;

//pjax刷新后相应插件的js都会失效，需要重新注册 https://github.com/yiisoft/yii2-jui/issues/9
//这里的对应的datepicker设置对应的参数-取pluginOptions
$datepickerConfig = '{"format":"yyyy-mm-dd","todayHighlight":true,"autoclose":true,"language":"zh-CN"}';
$js = "$(document).ready(function(){
		$('#pjax_result').on('pjax:success', function(e) {
		    jQuery('#datepicker_search_date').kvDatepicker($datepickerConfig); 
		});
    });";
$this->registerJs($js, \yii\web\View::POS_END);

?>
<?php \yii\widgets\Pjax::begin(['id' => 'pjax_result']) ?>
    <?= GridView::widget([
        'id' => 'grid_result', //必须设置id，如果页面有多个gridview，同时用了pjax，会导致pjax刷新页面混乱
        'dataProvider' => $dataProvider,
        'responsive' => true,
        'responsiveWrap' => false,
        'panel' => [
            'heading' => '<h3 class="panel-title">' . $this->title . '</h3>',
            'type' => 'info',
            'after' => false,
            'before' =>  '',
        ],
        'toolbar' => [
            [
                'content' => $this->render("pjax_search", ['params' => $params])
            ],
            /*'{export}',
            '{toggleData}',*/
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'header' => '#',],
            [
                'header' => 'Browser',
                'attribute' => 'browser',
                'hAlign' => GridView::ALIGN_CENTER,
                'vAlign' => GridView::ALIGN_MIDDLE,
            ],
            [
                'header' => 'Platform',
                'attribute' => 'platform',
                'hAlign' => GridView::ALIGN_CENTER,
                'vAlign' => GridView::ALIGN_MIDDLE,
            ],
            [
                'header' => 'Engine',
                'attribute' => 'engine',
                'hAlign' => GridView::ALIGN_CENTER,
                'vAlign' => GridView::ALIGN_MIDDLE,
            ],
        ],
        'layout' => '{items}{pager}',
        'summary' => '', //Total xxxx items.
        'pager' => [
            'options'=>['class'=>'pagination'],
            'prevPageLabel' => '上一页',
            'firstPageLabel'=> '首页',
            'nextPageLabel' => '下一页',
            'lastPageLabel' => '末页',
            'maxButtonCount'=>'10',
        ]
    ]); ?>
<?php \yii\widgets\Pjax::end() ?>