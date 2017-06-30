<?
include("./common.php");
extract($_GET);
extract($_POST);
$rs1=getPerson($cid);

#200508260743:vikas:linking spouses added. complicated procecudre still
$newcid=0;
$c = substr($spouse,0,1);
if($c == "=")
	$newcid = substr($spouse,1);

if($rs1->gender==1)
{
	if(!$newcid)
		$newcid=addPerson($spouse,0,0,0);
	$sql = "insert into marriages(husband_cid,wife_cid) values($cid,$newcid)";
	logThis(ADDSPOUSEWOMAN,"$cid;$newcid;");
	$sql2 = "update persons set mother_cid=$newcid where cid=$child_cid";
	$child_event = SETMOTHER;
	$child_param = "$child_cid;$newcid";
}
else
{
	if(!$newcid)
		$newcid=addPerson($spouse,1,0,0);
	$sql = "insert into marriages(husband_cid,wife_cid) values($newcid,$cid)";
	logThis(ADDSPOUSEMAN,"$cid;$newcid;");
	$sql2 = "update persons set father_cid=$newcid where cid=$child_cid";
	$child_event = SETFATHER;
	$child_param = "$child_cid;$newcid";
}
doInit();
#echo $sql;
doquery($sql);
if($child_cid>0)
{
	doquery($sql2);
	logThis($child_event,$child_param);
}
#exit;
redirect("openperson.php?cid=$cid");
?>
