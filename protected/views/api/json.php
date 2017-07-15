<?php
$cs = Yii::app()->clientScript;
$cs->reset();

error_log("added acl headers");
$this->layout=false;

array_walk_recursive($data,'changenumbers');
$json = json_encode ($data);
error_log("dumping json: " . $json);
if(!defined('UNIT_TESTING'))
{
    header("Content-Type: application/json");

    if(!empty($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header('Access-Control-Allow-Headers: ' . $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Length: " . strlen($json));
}

echo $json;
