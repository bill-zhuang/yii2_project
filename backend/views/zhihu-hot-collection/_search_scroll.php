<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Search\ZhihuHotCollectionSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $params array */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index-scroll'],
    'method' => 'get',
    "options" => ['class' => 'form-inline', 'autocomplete' => 'off'],
    'fieldConfig' => [
        'template' => "{input}",
        'labelOptions' => [
            'class' => 'control-label'
        ]
    ]
]); ?>

    <?= $form->field($model, 'title')->textInput(['placeholder'=> '标题']) ?>

<div class="form-group">
    <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
</div>
<div class="form-group">
    <?= Html::a('重置', ['index-scroll'], ['data-pjax'=>0, 'class'=>'btn btn-default form-group'])?>
</div>

<?php ActiveForm::end(); ?>
