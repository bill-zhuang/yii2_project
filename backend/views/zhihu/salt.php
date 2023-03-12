<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kucha\ueditor\UEditor;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\Search\ZhihuSaltSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $params array */

$this->title = '知乎盐选';
$this->params['breadcrumbs'][] = $this->title;

?>
<script>
function getDetail(content) {
    let editor = UE.getEditor('ueid');
    editor.setContent(content.replaceAll('class="invisible"',
        'class="invisible" style="display:none"'));
    //$('.modal-body').html(content);
    $('#mainModal').modal('show');
}

</script>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => true,
    'responsiveWrap' => false,
    'panel' => [
        'heading' => '<h3 class="panel-title">' . $this->title . '</h3>',
        'type' => 'info',
        'after' => false,
        //'before' =>  Html::a('新建', ['create'], ['class' => 'btn btn-success pull-left']) ,
    ],
    'toolbar' => [
        [
            'content' => $this->render("_search_salt", ['model' => $searchModel, 'params' => $params])
        ],
        '{export}',
        '{toggleData}',
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn', 'header' => '序号',],
        [
            'header' => '标题',
            'attribute' => 'title',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '回答简介',
            'attribute' => 'abbr_answer',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function ($model) {
                return urldecode($model->abbr_answer);
            }
        ],
        [
            'header' => '回答url',
            'attribute' => 'answer_url',
            'format' => 'raw',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function ($model) {
                if (!empty($model->answer_url)) {
                    return Html::a('跳转', $model->answer_url, ['target' => '_blank']);
                }
                return  '';
            }
        ],
        [
            'header' => '创建时间',
            'attribute' => 'create_time',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
        ],
        [
            'header' => '操作',
            'format' => 'raw',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'value' => function ($model) {
                $str = preg_replace('/<figure[^>]*>/', '', $model->content);
                $str = str_replace('</figure>', '', $str);
                $str = json_encode($str, JSON_UNESCAPED_UNICODE);
                return Html::button('详细',
                    ['onclick' => "getDetail($str)", 'class' => 'btn btn-info']);
            }
        ],
        /*[
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{detail}',
            'buttons' => [
                'detail' => function($url, $model){
                    $str = preg_replace('/<figure[^>]*>/', '', $model->content);
                    $str = str_replace('</figure>', '', $str);
                    $str = json_encode($str, JSON_UNESCAPED_UNICODE);
                    return Html::button('详细',
                        ['onclick' => "getDetail($str)", 'class' => 'btn btn-info']);
                },
            ]
        ],*/
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

<div class="modal fade" id="mainModal">
    <div class="modal-dialog modal-lg" style="height:auto; width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">详细</h4>
            </div>
            <div class="modal-body">
                <?=
                    UEditor::widget([
                        'name' => 'xxxx',
                        'id' => 'ueid',
                        'clientOptions' => [
                            'toolbars' => [
                                [
                                    'fullscreen', 'source', 'undo', 'redo', '|',
                                    'fontsize',
                                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                                    'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                                    'forecolor', 'backcolor', '|',
                                    'lineheight', '|',
                                    'indent', '|'
                                ],
                            ]
                        ],
                    ]);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

