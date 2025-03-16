<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $params array */

$this->title = '语文汉字测试';
$this->params['breadcrumbs'][] = $this->title;

?>

<script>
</script>

<div class="scrollable padder">
    <div class="row bg-light m-b">
        <div class="col-md-12">
            <section class="panel panel-info">
                <header class="panel-heading font-bold">
                    <?= $this->title ?>
                </header>
                <div class="panel-body">
                    <?= $this->render("_search", ['params' => $params]) ?>
                    <hr/>
                    <?= $this->render('index_list', ['dataProvider' => $dataProvider]) ?>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function plus(obj, id) {
        var badge = $(obj).prev('.badge-self').text();
        if (badge === '') {
            badge = 'x1';
        } else {
            badge = 'x' + (parseInt(badge.replace('x', '')) + 1);
        }
        $.ajax({
            type: "POST",
            url: "/letters/plus",
            data: {
                "id": id,
            },
            async: false,
            success: function (data) {
                if (data.code === 0) {
                    $(obj).prev('.badge-self').text(badge);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                ;
            }
        });
    }
</script>