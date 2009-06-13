<?
include("./common.php");
import_request_variables("pg","");
doquery("delete from marriages where $cid in (husband_cid,wife_cid)");
doquery("delete from persons where cid=$cid");
redirect("openperson.php?cid=$spouse_cid");
?>