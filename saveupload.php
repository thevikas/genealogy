<?
#cho getcwd() . "\n";
include("./common.php");

$cid =cleanvar("cid",0);
$name =mysql_escape_string(cleanvar("name",0));

$sql = "insert into pics(cid,name) values($cid,'$name')";
doquery($sql);

$pid = mysql_insert_id();

$sql = "update persons set bPics=1 where cid=$cid";
doquery($sql);

$imgname = $pid . ".jpg";
if($name == 'main')
	$imgname = "c" . $cid . ".jpg";

$uploadfile = $uploaddir . $imgname;
print "<pre>";
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	?>
	<html>
	<script type="text/javascript">
	function do1()
	{
		var frm = document.forms[0];
		frm.width.value = document.images[0].width;
		frm.height.value = document.images[0].height;
		frm.submit();
	}
	</script>
	<body onLoad="do1()">
	<form action="savepicsize.php">
	<img name="im" src="pics/<?=$imgname?>">
	<input type="hidden" name="width">
	<input type="hidden" name="height">
	<input type="cid" value="<?=$cid?>" name="cid">
	<input type="pid" value="<?=$pid?>" name="pid">
	</form>
	</body>
	</html>
	<?
    print "File is valid, and was successfully uploaded to [$uploadfile]. ";
    print "Here's some more debugging info:\n";
    print_r($_FILES);
} else {
    print "Possible file upload attack!  Here's some debugging info:\n";
    print_r($_FILES);
}
print "</pre>";
?>