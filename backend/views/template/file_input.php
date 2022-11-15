<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $params array */

$this->title = '文件Ajax上传';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php
$this->registerJs(
    '$("document").ready(function(){ 
		$("#modal-default").on("hide.bs.modal", function (){
		    if ($("input[name=\"page_reload_flag\"]").val() == 1) {
                location.reload();
            }
        });
    });'
);
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->title ?></h3>
    </div>
    <div class="panel-body">
        <?= Html::a('上传', ['#'],
            ['class' => 'btn btn-success', "data-toggle" => "modal", "data-target" => "#modal-default"]) ?>
        <hr/>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('file_input_item_view',['model' => $model]);
            },
            'itemOptions' => [//针对渲染的单个item
                'tag' => 'div',
                'class' => 'col-sm-2 panel-body'
            ],
            'layout' => '<div class="row">{items}</div>{pager}',
            'summary' => '', //Total xxxx items.
            'pager' => [
                'options'=>['class'=>'pagination pull-right'],
                'prevPageLabel' => '上一页',
                'firstPageLabel'=> '首页',
                'nextPageLabel' => '下一页',
                'lastPageLabel' => '末页',
                'maxButtonCount' => '10',
            ]
        ]); ?>
    </div>
</div>

<?= Html::hiddenInput('page_reload_flag', 0) ?>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">头像上传</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data', //图片上传设置 重要
                ],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-sm-4\">{input}</div><div class=\"help-block\">{error}</div>",
                    'labelOptions' => [
                        'class' => 'col-sm-2 control-label'
                    ]
                ]
            ]); ?>
            <div class="modal-body">
                <?=
                    FileInput::widget([
                        'name' => 'avatar[]',
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'language' => 'zh',
                            'uploadUrl' => \yii\helpers\Url::to('file-input-ajax'),
                            'maxFileCount' => 25,
                            'allowedFileExtensions' => ["png"],
                            'initialPreview' => [],
                            'initialPreviewAsData'=>true,
                            'showUpload' => true,
                            'showRemove' => true,
                        ],
                        'pluginEvents' => [
                            'fileuploaded' => 'function(object, data) {
                                $("input[name=\"page_reload_flag\"]").val(1);
                            }',
                        ],
                    ]);
                 ?>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
