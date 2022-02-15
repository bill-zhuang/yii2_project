<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Search\CalendarEventSearch */
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

    <?= $form->field($model, 'event')->textInput(['placeholder'=> '事项']) ?>

<div class="form-group">
    <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
</div>
<div class="form-group ">
    <?= Html::a('<i class="fa fa-repeat">日历模式</i>', ['calendar'], ['class'=>'btn btn-info', 'title'=>'日历模式'])?>
</div>
<div class="form-group">
    <?= Html::a('重置', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default form-group'])?>
</div>

<?php ActiveForm::end(); ?>
