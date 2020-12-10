<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ZhihuHotCollection */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '知乎热门收藏管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zhihu-hot-collection-view">
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除嘛?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <section class="scrollable padder">
        <div class="row bg-light m-b">
            <div class="col-md-12">
                <section class="panel panel-default">
                    <header class="panel-heading font-bold">详细</header>
                    <div class="panel-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                                            'id',
                            'title',
                            'abbr_answer',
                            'content:ntext',
                            'answer_url:url',
                            'status',
                            'create_time',
                            'update_time',
                        ],
                    ]) ?>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
