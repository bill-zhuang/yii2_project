<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Search\SqlLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $params array */

$this->title = '操作日志管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => true,
    'responsiveWrap' => false,
    'panel' => [
        'heading' => '<h3 class="panel-title">' . $this->title . '</h3>',
        'type' => 'danger',
        'after' => false,
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
            'header' => 'id',
            'attribute' => 'id',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => 'urid',
            'attribute' => 'urid',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => 'username',
            'attribute' => 'urid',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function($model) {
                $modelBkUser = User::findOne($model->urid);
                return isset($modelBkUser) ? $modelBkUser->username : '';
            }
        ],
        [
            'header' => 'ip',
            'attribute' => 'ipaddr',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => 'url',
            'attribute' => 'url',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '操作说明',
            'attribute' => 'detail',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '操作时间',
            'attribute' => 'create_time',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function($model) {
                return date('Y-m-d H:i:s', $model->create_time);
            }
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
