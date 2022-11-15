<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model  */
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>

<section class="scrollable padder">
    <div class="row bg-light m-b">
        <div class="col-md-12">
            <section class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="<?= $directoryAsset . $model['url'] ?>" alt="User profile picture">
                    </div><br/>
                    <?=
                     Html::a('删除', ['delete', 'id' => $model['id']], [
                        'data' => [
                            'confirm' => '确认删除?',
                            'method' => 'post',
                        ],
                         'class' => 'btn btn-primary btn-block'
                    ]);
                    ?>
                </div>
            </section>
        </div>
    </div>
</section>