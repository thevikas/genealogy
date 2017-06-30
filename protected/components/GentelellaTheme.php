<?php
class GentelellaTheme extends CTheme
{
    
    public function __construct($name,$basePath,$baseUrl)
    {
        parent::__construct($name, $basePath, $baseUrl);
        Yii::app()->clientScript->packages = require_once( realpath( $basePath . '/script-packages.php') );
    }
    
    
}