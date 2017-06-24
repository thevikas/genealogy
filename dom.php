<?
include("./common.php");
import_request_variables("pg","");
$sql = "update marriages set dom='$dom' where mid=$mid and $cid in (husband_cid,wife_cid)";
#echo $sql;
#exit;
doquery($sql);
redirect("openperson.php?cid=$cid");
?>
