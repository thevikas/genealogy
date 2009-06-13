<?
include("./common.php");
import_request_variables("pg","");
$title = "Family Tree";
include("./top.php");
if($edit == "yes")
	$showlink2_detail=true;
else
{	?><a href="?cid=<?=$cid?>&edit=yes&high=<?=$high?>">Detailed Report</a><?
}
	
#echo $edit;
#exit;
function showMarriages($cid,$gender,$name)
{
	global $high;
	$married=false;
	$r1 = doquery("select w.name as `wife`,h.name as `husband`,m.* from marriages m,persons h,persons w where w.cid=wife_cid and h.cid=husband_cid and $cid in (husband_cid,wife_cid) order by w.name");
	while($rs1=mysql_fetch_object($r1))
	{
		$married=true;
		?><li<?
		if(intval($cid) == intval($high))
		{
			echo " style=\"font-weight:bold;\" ";
		}
		?>><?
		if($cid == $rs1->husband_cid)
		{
		 	showPersonLink2($cid,$rs1->husband,1);
			echo " + ";
			showPersonLink2($rs1->wife_cid,$rs1->wife,0);
		}
		else
		{
		 	showPersonLink2($cid,$rs1->wife,0);
			echo " + ";
			showPersonLink2($rs1->husband_cid,$rs1->husband,1);
		}
		
		?><dir><?
		showChildren($rs1->husband_cid,$rs1->wife_cid);
		?></dir><?
	}
	if($married==false)
	{
		?><li><?
		showPersonLink2($cid,$name,$gender);
	}
}
function showChildren($fcid,$mcid)
{
	$r1 = doquery("select * from persons where father_cid=$fcid and mother_cid=$mcid order by name");
	while($rs1=mysql_fetch_object($r1))
	{
		#echo "cid=" . $rs1->cid;
		#exit;
		showMarriages($rs1->cid,$rs1->gender,$rs1->name);
	}	
}
function showFamily($cid)
{
	showMarriages($cid,"Root",1);
}
?>
<style type="text/css">
DIR,LI,BODY
{
font-size: 14px;
}
BODY > DIR > LI > DIR > LI > DIR > LI > DIR > LI
{
	list-style-image: url("imgs/li_1.gif");
}
BODY > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI
{
	list-style-image: url("imgs/li_2.gif")
}
BODY > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI
{
	list-style-image: url("imgs/li_3.gif")
}
BODY > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI
{
	list-style-image: url("imgs/li_4.gif")
}
BODY > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI
{
	list-style-image: url("imgs/li_5.gif")
}
BODY > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI
{
	list-style-image: url("imgs/li_6.gif")
}
BODY > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI
{
	list-style-image: url("imgs/li_7.gif")
}
BODY > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI > DIR > LI
{
	list-style-image: url("imgs/li_8.gif")
}
</style>
<?
echo "<dir>";
showFamily($cid);
echo "</dir>";
?>