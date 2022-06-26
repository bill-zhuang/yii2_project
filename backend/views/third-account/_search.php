<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Search\ThirdAccountSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $params array */
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

    <?= $form->field($model, 'appid')->textInput(['placeholder'=> 'appid']) ?>

    <?= $form->field($model, 'name')->textInput(['placeholder'=> '商户名']) ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

<div class="form-group">
    <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
</div>
<div class="form-group">
    <?= Html::a('重置', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default form-group'])?>
</div>

<?php ActiveForm::end(); ?>
