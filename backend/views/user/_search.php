<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Search\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    "options" => ['class' => 'form-inline'],
    'fieldConfig' => [
        'template' => "{input}",
        'labelOptions' => [
            'class' => 'control-label'
        ]
    ]
]); ?>

<?= $form->field($model, 'username')->textInput(['placeholder'=> '用户名']) ?>

<div class="form-group">
    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
