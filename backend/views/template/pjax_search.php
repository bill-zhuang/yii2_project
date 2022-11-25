<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $params array */
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-1',
    'action' => ['pjax-search'],
    'method' => 'get',
    //data-pjax为对应gridview外面包的pjax的id
    "options" => ['class' => 'form-inline', 'data-pjax' => '#pjax_result', 'autocomplete' => 'off'],
    'fieldConfig' => [
        'template' => "{input}",
        'labelOptions' => [
            'class' => 'control-label'
        ]
    ]
]); ?>
<div class="form-group">
    <?php echo DatePicker::widget([
        'id' => 'datepicker_search_date',
        'name' => 'search_date',
        'value' => $params['search_date'] ?? date('Y-m-d'),
        'options' => ['placeholder' => '请选择查询日期'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'autoclose' => true,
        ],
        'removeButton' => false,
    ]); ?>
</div>

<div class="form-group">
    <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
</div>
<div class="form-group">
    <?= Html::resetButton('重置', ['class'=>'btn btn-default form-group'])?>
</div>

<?php ActiveForm::end(); ?>
