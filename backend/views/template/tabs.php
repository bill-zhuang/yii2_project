<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $params array */

$this->title = 'Tabs示例';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->title ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <?php
                echo \yii\bootstrap\Tabs::widget([
                    'id' => 'xxxx',
                    'renderTabContent' => false,
                    'linkOptions' => ['data-toggle' => 'tab'],
                    'items' => [
                        [
                            'label' => 'Tab1',
                            'content' => '',
                            'url' => '#tab_1',
                            'active' => true,
                        ],
                        [
                            'label' => 'Tab2',
                            'content' => '',
                            'url' => '#tab_2',
                            'active' => false,
                        ],
                        [
                            'label' => 'Tab3',
                            'content' => '',
                            'url' => '#tab_3',
                            'active' => false,
                        ],
                    ]
                ]);
                ?>
            </div>
            <br/><br/><br/>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?= $this->render('tab_1'); ?>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        Tab2
                    </div>
                    <div class="tab-pane" id="tab_3">
                        Tab3
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

