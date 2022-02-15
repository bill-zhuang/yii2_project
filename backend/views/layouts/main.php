<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } elseif (class_exists('app\assets\AppAsset')) {
        app\assets\AppAsset::register($this);
    }
    if (class_exists('backend\assets\SlimScrollAsset')) {
        backend\assets\SlimScrollAsset::register($this);
    }
    if (class_exists('backend\assets\GrowlAsset')) {
        backend\assets\GrowlAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>Demo</title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini"><!-- fixed 需要slimscroll.js 不然侧边栏不会滚动 -->
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'footer.php'
        ) ?>

    </div>
    <style>
        .ui-menu {
            margin-top: 310px !important;
            margin-left: 245px !important;
        }
    </style>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
