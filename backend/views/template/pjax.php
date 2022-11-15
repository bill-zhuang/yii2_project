<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $params array */

$this->title = 'Pjax';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php \yii\widgets\Pjax::begin(['id' => 'pjax_result']) ?>
    <?= GridView::widget([
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