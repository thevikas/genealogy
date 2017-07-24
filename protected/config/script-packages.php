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
        'tree' => [
                'baseCssUrl' => '/css',
                'css' => [
                        'grayreport2.css'
                ],
                'js' => [
                        'tree.js'
                ],
                'depends' => [
                        'jquery',
                        'jquery-ui'
                ]
        ],  
        'd3' => [
                'baseCssUrl' => '/css',
                'css' => [
                ],
                'js' => [
                        'lodash.min.js',
                        'd3.min.js',
                ],
                'depends' => [
                ]
        ],
        'd3dtree' => [
                'baseCssUrl' => '/css',
                'css' => [
                ],
                'js' => [
                        'builder.js',
                        'dtree.js',
                        'dtree_init.js',
                ],
                'depends' => [
                        'd3',
                ]
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
