<?
include("./common.php");
import_request_variables("pg","");
$title = "Family Tree";

header("Content-Type: text/plain");

if($edit == "yes")
	$showlink2_detail=true;
else
{	?><a href="?cid=<?=$cid?>&edit=yes&high=<?=$high?>">Detailed Report</a><?
}
	
#echo $edit;
#exit;

function showMarriages($cid,$gender,$name,$fcid,$mcid)
{
	global $high;
	$married=false;
	$r1 = doquery("select w.name as `wife`,h.name as `husband`,m.* from marriages m,persons h,persons w where w.cid=wife_cid and h.cid=husband_cid and $cid in (husband_cid,wife_cid) order by w.name");
	while($rs1=mysql_fetch_object($r1))
	{
		$married=true;

		if($cid == $rs1->husband_cid)
		{
		 	showPersonLink_export($cid,$rs1->husband,1,$rs1->wife_cid,$fcid,$mcid);
			showPersonLink_export($rs1->wife_cid,$rs1->wife,0,$rs1->husband_cid,0,0);
		}
		else
		{
		 	showPersonLink_export($cid,$rs1->wife,0,$rs1->husband_cid,$fcid,$mcid);
			showPersonLink_export($rs1->husband_cid,$rs1->husband,1,$rs1->wife_cid,0,0);
		}
		
		showChildren($rs1->husband_cid,$rs1->wife_cid);
	}
	if($married==false)
	{
		showPersonLink_export($cid,$name,$gender,0,$fcid,$mcid);
	}
}
function showChildren($fcid,$mcid)
{
	$r1 = doquery("select * from persons where father_cid=$fcid and mother_cid=$mcid order by name");
	while($rs1=mysql_fetch_object($r1))
	{
		#echo "cid=" . $rs1->cid;
		#exit;
		showMarriages($rs1->cid,$rs1->gender,$rs1->name,$fcid,$mcid);
	}	
}
function showFamily($cid)
{
	showMarriages($cid,"Root",1,0,0);
}


showFamily($cid);
?>