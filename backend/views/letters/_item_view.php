<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model array */

$letter = $model['letter'];
$tags = '';
if ($model['err_cnt']) {
    $tags = 'x' . $model['err_cnt'];
}

?>
<style>
    .badge-self {
        position: absolute;
        top: 0;
        right: 0;
        width: 50px;
        height: 50px;
        /*background-color: red;*/
        color: red;
        font-weight: bolder;
        font-family: "consolas", serif;
        font-style: italic;
        /*color: white;*/
        border-radius: 50%;
        text-align: center;
        line-height: 15px;
    }
    .thumbs-up {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 50px;
        height: 40px;
        cursor: pointer;
    }
    .letter {
        font-size: 20px;
        font-weight: bolder;
    }
</style>
<section class="scrollable padder" >
    <div class="row bg-light m-b">
        <div class="col-md-12">
            <section class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <span class="letter"><?= $letter ?></span>
                        <span class="badge-self"><?= $tags ?></span>
                        <a class="thumbs-up" onclick="plus(this, <?= $model['lid'] ?>);">
                            <i class="fa fa-thumbs-o-up"></i>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>