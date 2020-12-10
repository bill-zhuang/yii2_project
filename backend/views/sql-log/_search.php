<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Search\SqlLogSearch */
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

    <div class="form-group">
        <?=
            DateTimePicker::widget([
                'name' => 'datetime',
                'value' => isset($params['datetime']) ? $params['datetime'] : '',
                'options' => ['placeholder' => '开始时间', 'class' => 'col-sm-2'],
                'pluginOptions' => [
                    'showSeconds' => true,
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'secondStep' => 5,
                    'format' => 'yyyy-mm-dd hh:ii:ss',
                    'autoclose' => true,
                ]
            ]);
        ?>
    </div>

    <?= $form->field($model, 'urid')->textInput(['placeholder'=> 'urid']) ?>

    <?= $form->field($model, 'ipaddr')->textInput(['placeholder'=> 'ip']) ?>

    <?= $form->field($model, 'url')->textInput(['placeholder'=> 'url']) ?>

    <?= $form->field($model, 'detail')->textInput(['placeholder'=> 'sql']) ?>

<div class="form-group">
    <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
</div>
<div class="form-group">
    <?= Html::a('重置', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default form-group'])?>
</div>

<?php ActiveForm::end(); ?>
