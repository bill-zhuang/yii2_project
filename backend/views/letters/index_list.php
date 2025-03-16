<?php

/* @var $dataProvider $dataProvider */

echo \yii\widgets\ListView::widget([
    'id' => 'listview_letter',
    'dataProvider' => $dataProvider,
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_item_view', ['model' => $model]);
    },
    'itemOptions' => [//针对渲染的单个item
        'tag' => 'div',
        'class' => 'col-sm-2'
    ],
    'layout' => '<div class="row">{items}</div>{pager}',
    'summary' => '', //Total xxxx items.
    'pager' => [
        'options' => ['class' => 'pagination pull-right'],
        'prevPageLabel' => '上一页',
        'firstPageLabel' => '首页',
        'nextPageLabel' => '下一页',
        'lastPageLabel' => '末页',
        'maxButtonCount' => '10',
    ]
]);