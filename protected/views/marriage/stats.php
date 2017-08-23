<?php
/* @var $this SiteController */
$this->breadcrumbs [] = __('Marriage Stats');

$this->pageTitle = "Database Statistics - Marriages - " . date('Y M d');

Yii::app ()->clientScript->registerCoreScript ( 'font-awesome' );

$this->widget ( 'zii.widgets.grid.CGridView',
        [
                'id' => 'marriage-stats-grid',
                'dataProvider' => $dp,
                // 'filter'=>$model,
                'columns' => [
                    [
                        'name' => 'hname',
                        "header" => __('Husband'),
                        'type' => 'raw',
                        'value' => function($data) {
                            return $data['husband']->getnamelink(['nospouse' => 1]);
                        }
                    ],
                    [
                        'name' => 'wname',
                        "header" => __('Wife'),
                        'type' => 'raw',
                        'value' => function($data) {
                            return $data['wife']->getnamelink(['nospouse' => 1]);
                        }
                    ],
                    [
                        'name' => 'mage',
                        "header" => __('MAGE'),
                    ],
                    [
                        'name' => 'Year',
                        'value' => function($data) {
                            return 2017 - $data['mage'];
                        }
                    ],
                    [
                        'name' => 'hmage',
                        "header" => __('AOM Husband'),
                    ],
                    [
                        'name' => 'wmage',
                        "header" => __('AOM Wife'),
                    ],
                ]
        ]
);
