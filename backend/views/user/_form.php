<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SignupForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal'
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-4\">{input}</div><div class=\"help-block\">{error}</div>",
            'labelOptions' => [
                'class' => 'col-sm-2 control-label'
            ]
        ]
    ]); ?>


    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'readonly' => !empty($model->username)])->label('用户名') ?>

    <?php
        $attr = ($model->isNew ? 'password' : 'modifyPassword');
        echo $form->field($model, $attr)->passwordInput()->label('密码');
    ?>
    <div class="col-md-2">
    </div>
    <div class="col-md-4">
        <?= Html::submitButton($model->isNew ? '创建' : '保存', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
