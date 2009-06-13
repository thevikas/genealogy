<?
include("./common.php");
import_request_variables("pg","");
//200607141509
$sql = "update persons set isDead = abs(isDead-1) where cid=$cid";
doquery($sql);
redirect("openperson.php?cid=$cid");
?>
