<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Search\CalendarEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $params array */

$this->title = '日历';
$this->params['breadcrumbs'][] = $this->title;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => true,
    'responsiveWrap' => false,
    'panel' => [
        'heading' => '<h3 class="panel-title">' . $this->title . '</h3>',
        'type' => 'info',
        'after' => false,
        'before' => Html::tag('div',
            Html::a('<i class="fa fa-repeat">日历模式</i>', ['calendar'], ['class'=>'btn btn-info'])
             . '&nbsp;' . Html::a('新增事项', ['create'], ['class' => 'btn btn-success']),
            ['class' => 'pull-left']),
    ],
    'toolbar' => [
        [
            'content' => $this->render("_search", ['model' => $searchModel, 'params' => $params])
        ],
        '{export}',
        '{toggleData}',
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn', 'header' => '序号',],
        [
            'header' => '事项',
            'attribute' => 'event',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '开始时间',
            'attribute' => 'start_date_time',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function ($model) {
                return $model->start_date . ' ' . $model->start_time;
            }
        ],
        [
            'header' => '结束时间',
            'attribute' => 'end_date',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function ($model) {
                return $model->end_date . ' ' . $model->end_time;
            }
        ],
        [
            'header' => '修改时间',
            'attribute' => 'update_time',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function($url, $model){
                    return Html::a('编辑', ['update', 'id' => $model->id]);
                },
                'delete' => function($url, $model){
                    return Html::a('删除', ['delete', 'id' => $model->id], [
                        'data' => [
                            'confirm' => '确认删除?',
                            'method' => 'post',
                        ],
                    ]);
                }
            ]
        ],
    ],
    'layout' => '{items}{pager}',
    //'summary' => '', //Total xxxx items.
    'pager' => [
        'options'=>['class'=>'pagination'],
        'prevPageLabel' => '上一页',
        'firstPageLabel'=> '首页',
        'nextPageLabel' => '下一页',
        'lastPageLabel' => '末页',
        'maxButtonCount'=>'10',
    ]
]); ?>
