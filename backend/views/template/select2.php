<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $params array */

$this->title = 'Select2 Ajax';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
            <?php $form = ActiveForm::begin([
                'id' => 'form-select2',
                'action' => ['select2'],
                'method' => 'get',
                "options" => ['class' => 'form-inline'],
                'fieldConfig' => [
                    'template' => "{input}",
                    'labelOptions' => [
                        'class' => 'control-label'
                    ]
                ],
            ]); ?>

                <div class="form-group" style="width: 300px;">
                    <?php echo \kartik\select2\Select2::widget([
                        'name' => 'nickname',
                        'data' => [],
                        //'language' => 'zh_CN',
                        'options' => ['placeholder' => '请输入', 'multiple' => false, ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'ajax' => [
                                'url' => \yii\helpers\Url::to('select2-ajax'),
                                'dataType' => 'json',
                                'processResults' => new \yii\web\JsExpression('
                                    function(data, params) {
                                        return data;
                                    }
                                '),
                            ],
                        ],
                        'pluginEvents' => [
                            "select2:select" => "function(e) {
                                //console.log(e.params.data);
                            }",
                        ],
                    ]); ?>
                </div>

            <div class="form-group">
                <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="form-group">
                <?= Html::resetButton('重置', ['class'=>'btn btn-default form-group'])?>
            </div>

            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>