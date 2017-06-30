<?php
return array (
        'jquery' => [ 
                'js' => [ 
                    'jquery.js', 
                ] 
        ],
        'jquery-ui' => [ 
                'baseCssUrl' => '/css',
                'js' => [ 
                        'jquery-ui.js' 
                ],
                'css' => [ 
                        'jquery-ui.css' 
                ],
                'depends' => [ 
                        'jquery' 
                ] 
        ],
        'bootstrap' => [
                'baseCssUrl' => '/css',
                'css' => [
                        'bootstrap.min.css',
                        'font-awesome.min.css',
                ],
                'js' => [
                        'bootstrap.min.js',
                ],
                'depends' => [
                        'jquery'
                ]
        ],
        'matquickform' => [
                'baseCssUrl' => '/css',
                'css' => [ 
                        'matquickform.css' 
                ],
                'js' => [
                        'matquickform.js'
                ],
                'depends' => [
                        'jquery',
                        'jquery-ui'
                ]
        ],
        'datepicker' => [
                'baseCssUrl' => '/css',
                'css' => [ 
                        'datepicker.css' 
                ],
                'js' => [
                        'datepicker.js',
                        'relpicker.js'
                ],
                'depends' => [
                        'jquery',
                        'jquery-ui'
                ]
        ],
        'daychart' => [
                'baseCssUrl' => '/css',
                'css' => [
                        'bigscreen.css'
                ],
                'depends' => [
                        'jquery',
                ]
        ],
        'gnattchart' => [
                'baseCssUrl' => '/css',
                'css' => [
                        'bigscreen.css',
                        'gnatt.css'
                ],
                'depends' => [
                        'jquery',
                        'jquery-ui'
                ],
            ],
        'autocomplete' => [
                'baseCssUrl' => '/css',
                'js' => [
                        'autocompletefunc.js',
                ],
                'depends' => [
                        'jquery-ui',
                ],
        ],
);
