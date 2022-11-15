<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $params array */
?>
<?php
$this->registerJs(
    '$("document").ready(function(){ 
		$("#pjax_search_form").on("pjax:end", function() {
			$.pjax.reload({container:"#pjax_result"});  //测试下来这个注释掉也不影响
		});
    });'
);
?>

<?php \yii\widgets\Pjax::begin(['id' => 'pjax_search_form',]) ?>
    <?php $form = ActiveForm::begin([
        'id' => 'form-1',
        'action' => ['pjax-search'],
        'method' => 'get',
        "options" => ['class' => 'form-inline', 'data-pjax' => true, 'autocomplete' => 'off'],
        'fieldConfig' => [
            'template' => "{input}",
            'labelOptions' => [
                'class' => 'control-label'
            ]
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="form-group">
        <?= Html::resetButton('重置', ['class'=>'btn btn-default form-group'])?>
    </div>

    <?php ActiveForm::end(); ?>
<?php \yii\widgets\Pjax::end(); ?>
