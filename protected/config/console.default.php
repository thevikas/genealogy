<?php

function __($string, $params = array(), $category = "")
{
    if (class_exists ( 'Yii' ))
        return Yii::t ( $category, $string, $params );
    return $string;
}

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array (
        'basePath' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
        'name' => 'My Console Application',
        
        // preloading 'log' component
        'preload' => array (
                'log' 
        ),
        
        'import' => array (
                'application.models.*',
                'application.components.*',
                'application.behaviours.*',
                'application.controllers.*' 
        ),
        
        // application components
        'components' => array (
                
                'db' => array (
                        'connectionString' => 'mysql:host=127.0.0.1;dbname=gene',
                        // 'emulatePrepare' => true,
                        'username' => 'root',
                        'password' => '',
                        'charset' => 'utf8' 
                    // 'schemaCachingDuration'=>60*60
                ),
                'testdb' => array (
                        'class' => 'CDbConnection',
                        'connectionString' => 'mysql:host=127.0.0.1;dbname=gene_test',
                        'username' => 'root',
                        'password' => '',
                        'charset' => 'utf8' 
                ),
                
                'log' => array (
                        'class' => 'CLogRouter',
                        'routes' => array (
                                array (
                                        'class' => 'CFileLogRoute',
                                        'levels' => 'error, warning' 
                                ) 
                        ) 
                ) 
        
        ),
        'params' => [ ] 
);
