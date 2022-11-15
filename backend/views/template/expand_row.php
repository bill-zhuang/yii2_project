<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use kartik\grid\ExpandRowColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $params array */

$this->title = 'Expand Row';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php
$this->registerJs(' $(document).ready(function () {
        var $grid = $("#expand_grid");
        $grid.on("kvexprow:loaded", function (event, ind, key, extra) {
            //console.log(key);
        });
    });', \yii\web\View::POS_END);
?>
<?= GridView::widget([
    'id' => 'expand_grid',
    'dataProvider' => $dataProvider,
    'responsive' => true,
    'responsiveWrap' => false,
    'panel' => [
        'heading' => '<h3 class="panel-title">' . $this->title . '</h3>',
        'type' => 'default',
        'after' => false,
        'before' =>  '',
    ],
    'toolbar' => [
        /*[
            'content' => $this->render("_search", ['params' => $params])
        ],*/
        /*'{export}',
        '{toggleData}',*/
    ],
    'floatHeader' => true,
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn', 'header' => '#',],
        [
            'header' => '#',
            'class' => 'kartik\grid\ExpandRowColumn',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detailUrl' => \yii\helpers\Url::to(['expand-row-detail']),
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => false,
            'enableRowClick' => true,
            'allowBatchToggle' => false,
            'expandIcon' => '',
            'collapseIcon' => '',
        ],
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
