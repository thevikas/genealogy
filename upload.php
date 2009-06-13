<?
#200507180812
include("./common.php");
import_request_variables("pg","");
$rs = getPerson($cid);
$title = $rs->name . " - Uploading Pictures";
include("./top.php");

$name="";
if($rs->bPics==0)
	$name = "main";
?>
<form enctype="multipart/form-data" action="saveupload.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input type="hidden" name="cid" value="<?=$cid?>">
Name: <input type="text" name="name" value="<?=$name?>"><br/>
<br/>
File: <input name="userfile" type="file">
<br/>
<input type="submit" value="Send File">
</form>
