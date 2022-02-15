<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\CalendarEvent */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    $model->start_date = $model->end_date = date('Y-m-d');
}
?>

<div class="calendar-event-form">

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

    <?= $form->field($model, 'event')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="calendar_event_start_datetime">开始时间</label>
        <div class="col-sm-2">
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'start_date',
                'removeButton' => false,
                //'options' => ['placeholder' => '开始日期'],
                'pluginOptions' => [
                    'locale' => 'zh-CN',
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]) ?>
        </div>
        <div class="col-sm-2">
            <?= TimePicker::widget([
                'model' => $model,
                'attribute' => 'start_time',
                'pluginOptions' => [
                    'showMeridian' => false,
                    'showSeconds' => false,
                    'defaultTime' => 'current',
                    'locale' => 'zh-CN',
                ]
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="calendar_event_end_datetime">结束时间</label>
        <div class="col-sm-2">
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'end_date',
                'removeButton' => false,
                //'options' => ['placeholder' => '结束日期'],
                'pluginOptions' => [
                    'locale' => 'zh-CN',
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]) ?>
        </div>
        <div class="col-sm-2">
            <?= TimePicker::widget([
                'model' => $model,
                'attribute' => 'end_time',
                'pluginOptions' => [
                    'showMeridian' => false,
                    'showSeconds' => false,
                    'defaultTime' => 'current',
                    'locale' => 'zh-CN',
                ]
            ]) ?>
        </div>
    </div>

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