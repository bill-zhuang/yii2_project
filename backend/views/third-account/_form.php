<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ThirdAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="third-account-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-4\">{input}</div><div class=\"help-block\">{error}</div>",
            'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'appid')->textInput(['maxlength' => true])->label('APPID') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('商户名') ?>

    <div class="col-md-2">
    </div>
    <div class="col-md-4">
        <?= Html::checkbox('ckOption', false, ['label' => '查看', 'value' => 'view', 'class' => 'ckMark']) ?>
        <?= Html::checkbox('ckOption', false, ['label' => '继续创建', 'value' => 'create', 'class' => 'ckMark']) ?>
        <?= Html::checkbox('ckOption', false, ['label' => '继续编辑', 'value' => 'update', 'class' => 'ckMark']) ?>
        <?= Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>