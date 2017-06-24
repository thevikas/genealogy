<?
#echo getcwd() . "\n";
include("./common.php");
$width = cleanvar("width",0);
$height = cleanvar("height",0);
$pid = cleanvar("pid",0);
$cid = cleanvar("cid",0);
$sql = "update pics set width=$width,height=$height where pid=$pid and cid=$cid";
#echo $sql;
#exit;
doquery($sql);
redirect("openperson.php?cid=$cid");
?>