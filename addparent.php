<?
include("./common.php");
#import_request_variables("pg","");

$cid = cleanvarg("cid","");
$gender = cleanvarg("gender","");
$name= cleanvarg("name","");

$r1=doquery("select father_cid,mother_cid from persons where cid=$cid");
$rs1=mysql_fetch_object($r1);
$second_parent = 0;
if($gender && $rs1->mother_cid>0)
	$second_parent=$rs1->mother_cid;
else if($gender==0 && $rs1->father_cid>0)
	$second_parent=$rs1->father_cid;

$marry = cleanvarg("marry","");
if($second_parent>0 && $marry!="no")
{
	echo "Add a marriage record as well?"
	?>
	<a href="javascript:document.forms['addspouse'].submit()">[Yes]</a>
	<a href="javascript:window.location='addparent.php?cid=<?=$cid?>&gender=<?=$gender?>&name=<?=$name?>&marry=no'">[No]</a>
	<?
	addSpouseForm($second_parent,$name,$cid);
	exit;
}

$newcid=addPerson($name,$gender,0,0);
$parent = $gender ? "father_cid" : "mother_cid";
$sql = "update persons set $parent=$newcid where cid=$cid";
doquery($sql);
logThis(ADDPARENT,"$cid;$newcid;$parent");
doInit();

header("Location: openperson.php?cid=$cid");
?>