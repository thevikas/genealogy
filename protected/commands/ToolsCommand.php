<?php
class ToolsCommand extends CConsoleCommand
{
    var $inbox;
    var $debug = 0;
    var $items = array ();
    var $hits = array ();

    public function actionsetnames()
    {
        Yii::app()->db->createCommand("update persons set name = concat(firstname,' ',lastname)")->execute();
    }
}

function htmlentities2($str)
{
    return str_replace ( '&', '&amp;', $str );
}