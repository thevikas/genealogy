<?php
die(__FILE__);
require_once(Yii::app()->basePath . "/../circlechartlib.php");
#print_r($person->getArray());
/*
$sql="select * from persons where cid=$cid";
$r = doquery($sql);
$rs=mysql_fetch_object($r);
$title = "Summary - " . $rs->firstname . " " . $rs->lastname;
addMRU($cid);
logThis(SUMMARY,$cid);
#include("./top.php");

require_once("circlechartlib.php");

$pp = new clsPerson();
$pp->load($cid);
 */
$arr = $person->getArray();
#print_r($arr);
#die;

header("Content-Type: image/svg+xml");
echo "<" . "?xml version=\"1.0\" standalone=\"no\"?" . ">";?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" 
  "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg width="2000" height="2000"
     xmlns="http://www.w3.org/2000/svg" 
     xmlns:xlink="http://www.w3.org/1999/xlink"
     version="1.1">
  <style type="text/css"><![CDATA[
    .Border { fill:none; stroke:blue; stroke-width:1 }
    .Connect { fill:none; stroke:#888888; stroke-width:2 }
    .SamplePath { fill:none; stroke:red; stroke-width:5 }
    .EndPoint { fill:none; stroke:#888888; stroke-width:2 }
    .CtlPoint { fill:#888888; stroke:none }
    .AutoCtlPoint { fill:none; stroke:blue; stroke-width:4 }
    .Label { font-size:22; font-family:Verdana }
    .txt
    {
	font-family: verdana;
	font-size: .5em;
	border: solid 1px green;
    }
    .root
{
    color: white;
    font-weight: bold;
    font-size: 1.5em;
}
    .level1
    {
        font-size: .5em;
    }

    .level2
    {
        font-size: .45em;
    }
 
    .level3
    {
        font-size: .3em;
    }

    .level4
    {
        font-size: .25em;
    }
    .level5
    {
        font-size: .2em;
    }
    .level6
    {
        font-size: .15em;
    }
    .level7
    {
        font-size: .1em;
    }
    .level8
    {
        font-size: .05em;
    }
    .level9
    {
        font-size: .001em;
    }
    .level10
    {
        font-size: .0005em;
    }
  ]]></style>
	
<?

$arr2 = $arr;array();

ob_start();
drawTree($arr2,1,360,0,0);
$buf = ob_get_contents();
ob_end_clean();

drawLevels($maxLevel,$arr2);
echo $buf;
echo "</svg>";


