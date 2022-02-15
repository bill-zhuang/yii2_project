<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $params array */

$this->title = '用户管理';
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
        [
            'header' => 'ID',
            'attribute' => 'id',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '用户名',
            'attribute' => 'username',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '角色',
            'attribute' => 'urid',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function($model) {
                if (isset(\Yii::$app->authManager)) {
                    $roles = \Yii::$app->authManager->getRolesByUser($model->id);
                    return implode(', ', array_column($roles, 'description'));
                }
                return '';
            }
        ],
        [
            'header' => '状态',
            'attribute' => 'status',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function($model) {
                return isset(User::$STATUS[$model->status]) ? User::$STATUS[$model->status] : '';
            }
        ],
        [
            'header' => '创建时间',
            'attribute' => 'created_at',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function($model) {
                return date('Y-m-d H:i:s', $model->created_at);
            }
        ],
        [
            'header' => '更新时间',
            'attribute' => 'updated_at',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function($model) {
                return date('Y-m-d H:i:s', $model->updated_at);
            }
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '操作',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function($url, $model){
                    return Html::a('分配角色', '/admin/assignment/view?id=' . $model->id);
                },
                'update' => function($url, $model){
                    return Html::a('编辑', '/user/update?id=' . $model->id);
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
    //'layout' => '{items}{pager}',
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