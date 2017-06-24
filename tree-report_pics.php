<?
$yrs_suffix=false;
include("./common.php");
import_request_variables("pg","");
$title = "Family Tree";
include("./top.php");

$level = 0;
function showMarriages($cid,$gender,$name,$level,$isDead,$bpic)
{
	global $high;
	$married=false;

	?><table class="level<?=$level?>"><?	
	#20060708
	#1) first list the wife and husband
	
	#$sql = "select w.name as `wife`,h.name as `husband`,m.*,h.treepos as htp,w.treepos as wtp, w.dob as `w_dob`, h.dob as `h_dob`,  w.isDead as `w_dead`, h.isDead as `h_dead`,w.father_cid as `w_father`,h.father_cid as `h_father`,ws.father_root as `w_father_root`,hs.father_root as `h_father_root` from marriages m,persons h,persons w,stats hs,stats ws where hs.cid = h.cid and ws.cid=w.cid and w.cid=wife_cid and h.cid=husband_cid and $cid in (husband_cid,wife_cid) order by w.name";
	$sql = "select w.name as `wife`,h.name as `husband`,m.*,h.treepos as htp,w.treepos as wtp, w.dob as `w_dob`, h.dob as `h_dob`,  w.isDead as `w_dead`, h.isDead as `h_dead`,h.father_root as `h_root`,w.father_root as `w_root`,h.father_cid as `h_father_cid`,h.bPics as `h_pic`,w.bPics as `w_pic` from marriages m,persons h,persons w where w.cid=wife_cid and h.cid=husband_cid and $cid in (husband_cid,wife_cid) order by w.name";
	$r1 = doquery($sql);
	
	while($rs1=mysql_fetch_object($r1))
	{
		$married=true;
		if(intval($cid) == intval($high))
		{
			#echo " style=\"font-weight:bold;\" ";
		}
		?>
		<tr><td valign="top">
		<?

		if($gender == "Root" && $rs1->h_father_cid>0)
		{
			?>
			<a href="?cid=<?=$rs1->h_father_cid?>#p<?=$cid?>">Up</a>
			<?	
		}

		if($cid == $rs1->husband_cid)
		{
			?><div class="left_spouse"><?
			
			if($rs1->h_pic>0)
			{
				?>
				<img class="left pic" src="pics/c<?=$cid?>.jpg" width="50"/>
				<?
			}
			if($rs1->w_pic>0)
			{
				?>
				<img class="right pic" src="pics/c<?=$rs1->wife_cid?>.jpg" width="50"/>
				<?
			}
			echo $rs1->htp;
			
			showPersonLink2($cid,$rs1->husband,1,$rs1->h_dead,0,$rs1->h_pic);
			$age = getYearsCount($rs1->h_dob,time());
			if($age!="")
				echo " ($age)";
			?> + <?
			
			showPersonLink2($rs1->wife_cid,$rs1->wife,0,$rs1->w_dead,$rs1->w_root,$rs1->w_pic);
			$age = getYearsCount($rs1->w_dob,time());
			if($age!="")
				echo " ($age)";
			?></div><?
		}
		else
		{
			?><div class="left_spouse"><?
			
			if($rs1->w_pic>0)
			{
				?>
				<img class="left pic" src="pics/c<?=$rs1->wife_cid?>.jpg" width="50"/>
				<?
			}
			if($rs1->w_pic>0)
			{
				?>
				<img class="right pic" src="pics/c<?=$rs1->husband_cid?>.jpg" width="50"/>
				<?
			}
			
			echo $rs1->wtp;
			showPersonLink2($cid,$rs1->wife,0,$rs1->w_dead,0,$rs1->w_pic);
			$age = getYearsCount($rs1->w_dob,time());
			if($age!="")
				echo " ($age)";
			?> + <?
			showPersonLink2($rs1->husband_cid,$rs1->husband,1,$rs1->h_dead,$rs1->h_root,$rs1->w_pic);
			$age = getYearsCount($rs1->h_dob,time());
			if($age!="")
				echo " ($age)";
			?></div><?
		}
		#2) list all thier children in the foloowing tabe
		?>
				<?
				showChildren($rs1->husband_cid,$rs1->wife_cid,$level);
				?>
				</td>
		</tr>
		<?
	}
	if($married==false)
	{
		?><tr><td valign="top">
		<?
		if($cid>0)
		{
			?>
			<img class="left pic" src="pics/c<?=$cid?>.jpg" width="50"/>
			<?
		}

		showPersonLink2($cid,$name,$gender,$isDead,0,$bpic);
		$age = getAge($cid,time());
		if($age!="")
			echo " ($age)";
		?></td></tr><?
	}
	?>
	</table>
	<?
}
function showChildren($fcid,$mcid,$level)
{
	$child_count=0;
	$r1 = doquery("select * from persons where father_cid=$fcid and mother_cid=$mcid order by treepos");
	while($rs1=mysql_fetch_object($r1))
	{
		#echo "cid=" . $rs1->cid;
		#exit;
		$child_count++;
		showMarriages($rs1->cid,$rs1->gender,$rs1->name,$level+1,$rs1->isDead,$rs1->bPics);
		
	}	
}
function showFamily($cid)
{
	showMarriages($cid,"Root",1,1,false,0);
}
?>
<style type="text/css">
@import "grayreport.css";
</style>
<div id="box">
<?
echo "<dir>";
$counter = 0;
showFamily($cid);
echo "</dir>";
?>
<h3><?=$counter?></h3>
</div>