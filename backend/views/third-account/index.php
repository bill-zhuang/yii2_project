<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Search\ThirdAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $params array */

$this->title = '对接方账号管理';
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
        'before' =>  Html::a('新建', ['create'], ['class' => 'btn btn-success pull-left']) ,
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
        /*[
            'header' => 'id',
            'attribute' => 'id',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],*/
        [
            'header' => 'APPID',
            'attribute' => 'appid',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '第三方',
            'attribute' => 'name',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '公钥',
            'attribute' => 'pub_key',
            'format' => 'raw',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function ($model) {
                return Html::a('下载',
                    ['key-download', 'id' => $model->id, 'type' => 'pub'], ['target' => '_blank']);
            }
        ],
        [
            'header' => '私钥',
            'attribute' => 'pri_key',
            'format' => 'raw',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function ($model) {
                return Html::a('下载',
                    ['key-download', 'id' => $model->id, 'type' => 'pri'], ['target' => '_blank']);
            }
        ],
        [
            'header' => '状态',
            'attribute' => 'status',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '创建时间',
            'attribute' => 'create_time',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '更新时间',
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
