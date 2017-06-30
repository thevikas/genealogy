<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array (
        'basePath' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
        'name' => 'My Web Application',
        
        // preloading 'log' component
        'preload' => array (
                'log' 
        ),
        
        // autoloading model and component classes
        'import' => array (
                'application.models.*',
                'application.components.*',
                'application.behaviours.*'
        ),
        
        'modules' => array (
                // uncomment the following to enable the Gii tool
                'gii' => array (
                        'class' => 'system.gii.GiiModule',
                        'password' => 'tj18',
                        // If removed, Gii defaults to localhost only. Edit
                        // carefully to taste.
                        'ipFilters' => array (
                                '127.0.0.1',
                                '::1' 
                        ) 
                ) 
        ),
        
        // application components
        'components' => array (
                'cache' => array (
                        'class' => 'WPSuperCache'
                ),
                'user' => array (
                        // enable cookie-based authentication
                        'allowAutoLogin' => true 
                ),
                // uncomment the following to enable URLs in path-format
                
                'urlManager' => array (
                        'urlFormat' => 'path',
                        'rules' => array (
                                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                                '<controller:\w+>/<action:\w+>' => '<controller>/<action>' 
                        ) 
                ),
                
                'db' => array (
                        'connectionString' => 'mysql:host=localhost;dbname=tasker',
                        'emulatePrepare' => true,
                        'username' => 'root',
                        'password' => '',
                        'charset' => 'utf8',
                        'schemaCachingDuration'=>60*60
                ),
                'errorHandler' => array (
                        // use 'site/error' action to display errors
                        'errorAction' => 'site/error' 
                ),
                'log' => array (
                        'class' => 'CLogRouter',
                        'routes' => array (
                                array (
                                        'class' => 'CFileLogRoute',
                                        //'levels' => 'error, warning' 
                                ),
                                /*array (
                                        'class' => 'CWebLogRoute'
                                )*/
                        ),
                        // uncomment the following to show log messages on web
                        // pages                        
                         
                ),
                'clientScript' => array (
                        
                        'CoreScriptUrl' => '/js',
                        'coreScriptPosition' => CClientScript::POS_END,
                        'packages' => include __DIR__ . '/script-packages.php',
                        /*'scriptMap' => array (
                                'jquery.js' => false,
                                'jquery.min.js' => false 
                        ) */
                ), //clientScript
                 
        ),
        
        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params' => array (
                // this is used in contact page
                'adminEmail' => 'webmaster@example.com',
                'cachetime' => 60*60,
                'units' => [ 
                        'DAY' => 2 
                ] 
        ), 
);