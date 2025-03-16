<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Letters;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $params array */

$grades = Letters::$gradeList;
$grades[0] = '年级';
ksort($grades);
$types = Letters::$typeList;
$types[0] = '全部';
ksort($types);
?>


<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'id' => 'search',
    "options" => ['class' => 'form-inline', 'autocomplete' => 'off'],
    'fieldConfig' => [
        'template' => "{input}",
        'labelOptions' => [
            'class' => 'control-label'
        ]
    ]
]); ?>

<div class="form-group">
    <?= Html::dropDownList('grade', $params['grade'] ?? 0, $grades, ['class' => 'form-control']) ?>
</div>
<div class="form-group">
    <?= Html::dropDownList('type', $params['type'] ?? 0, $types, ['class' => 'form-control']) ?>
</div>

<div class="form-group">
    <?= Html::textInput('letter_end', $params['letter_end'] ?? '', ['class' => 'form-control', 'placeholder'=> '结束字']) ?>
</div>

<div class="form-group">
    <span>只包含错字:</span>
    <?= Html::checkbox('flag_err', $params['flag_err'] ?? false) ?>
</div>

<div class="form-group">
    <?= Html::submitButton('生成测试', ['class' => 'btn btn-primary', 'id' => 'gen']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$ajaxJs = '
    $(document).ready(function () {
        $("#gen").click(function(e){
            e.preventDefault();
            // submit form
            $.ajax({
                url    : "index",
                type   : "get",
                data   : $("#search").serialize(),
                success: function (response) {
                    $("#listview_letter").html(response);
                },
                error  : function () {
                    console.log("errror");
                }
            });
            return false;
        });
    });
';

$this->registerJs($ajaxJs, \yii\web\View::POS_END);
?>
