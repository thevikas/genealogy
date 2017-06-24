<?
include("./common.php");
$title = "Search Results";

include("./top.php");
import_request_variables("pg","");
$a=0;
if($a==1)
{	
	$search_more = "";
	if(strlen($phones)>0)
		$search_more .= " and (phone_res like '%$phones%' or " .
		"phone_office like '%$phones%' or " .
		"phone_mobile like '%$phones%')";

	if(strlen($email)>0)
		$search_more .= " and email like  '%$email%'";

	if(strlen($address)>0)
		$search_more .= " and address like  '%$address%'";

	//20050423-on-site
	if(strlen($proff)>0)
		$search_more .= " and profession like '%$proff%'";

	//200504301737: new search fields
	if(strlen($country)>0)
		$search_more .= " and country like '%$country%'";
	if(strlen($travel_agent)>0)
		$search_more .= " and travel_agent like '%$travel_agent%'";
	if(strlen($comments)>0)
		$search_more .= " and comments like '%$comments%'";
}

if(isset($start) && $start>0)
	$start+=0;
else
	$start = 0;

$per_page=30; //200504301739
$search_more = "";
#200508020742:vikas:added simply name in the search clause also
$wheresql=" from persons p 
left join 
persons father on 
father.cid=p.father_cid where p.firstname like '%$firstname%' and p.lastname like '%$lastname%' and p.name like '%$name%' and p.deleted=0" . $search_more;
$sql = "select count(*) as `c` $wheresql";
#echo $sql;
$r = doquery($sql);
$rs = mysql_fetch_object($r);
$rscount = $rs->c;
$sql = "select p.*,concat(father.firstname,' ',father.lastname) as `father_name` $wheresql limit $start,$per_page";
echo $sql;
$r = doquery($sql)
?>
<a href="javascript:doback()">Back</a>|<a href="javascript:donext()">Next</a>
(<?=$rscount?> records found)
<br/><br/>
<table bgcolor="#0000ff" cellspacing=1 cellpadding=2>
	<TR class="head" bgcolor="#cfcfff">
		<td></td>
		<TD>Name</TD>
		<TD>Father Name</TD>
		<TD>City</TD>
		<TD>Phone</TD>
		<TD>Last Query</TD>
         <td></td>
	</TR>
<?
$ctr=0;
$last_cid=0;
while($rs=mysql_fetch_object($r))
{
	$ctr++;
	$cid = $rs->cid;
	$last_cid = $cid;
	?>
	<TR style="" bgcolor="#efefff">
		<td>[<a href="editperson.php?cid=<?=$cid?>">Edit</a>]
		[<a href="editquery.php?qid=-1&cid=<?=$cid?>">New Query</a>]
		</td>
		<TD><a href="openperson.php?cid=<?=$cid?>"><?=$rs->firstname?> <?=$rs->lastname?></a></TD>
		<TD><a href="openperson.php?cid=<?=$rs->father_cid?>"><?=$rs->father_name?></a></TD>
		<TD><? # $rs->city?></TD>
		<TD><?=$rs->phone_mobile?> <?=$rs->phone_res?> <?=$rs->phone_off?></TD>
		<td>
		</td>
	</TR>
	<?	
	
}

if(!$ctr) echo "<tr><td width=\"500\" bgcolor=\"white\" colspan=\"5\" align=\"center\"><i>No records found</i> (<a href=\"editperson.php?cid=-1&lastname=$lastname&firstname=$firstname&city=$city\">Add New</a>)</td></tr>";
logThis(SEARCH,"2:$firstname;$lastname;$city;$ctr");

?><script><?
if($ctr==1)
{
logThis(RUSHHOUR,"1;$firstname;$lastname;$city,$cid");
 ?>
window.location = "openperson.php?cid=<?=$cid?>";
<?
}
else if($ctr==0)
{
	if($stype==1)
	{
		logThis(RUSHHOUR,"0;$firstname;$lastname;$city");
		?>window.location = "editperson.php?rush=1&cid=-1&firstname=<?=$firstname?>&lastname=<?=$lastname?>&city=<?=$city?>";<?
				
	}
}
?>
</script>
</table>
<script type="text/javascript">
var frm;
function fillform() {
	frm = document.forms["moreform"];
	frm.firstname.value = "<?=$firstname?>";
	frm.lastname.value = "<?=$lastname?>";
	frm.city.value = "<?=$city?>";
	frm.phones.value = "<?=$phones?>";
	frm.email.value = "<?=$email?>";
	frm.address.value = "<?=$address?>";
	frm.country.value = "<?=$country?>";
	frm.travel_agent.value = "<?=$travel_agent?>";
	frm.proff.value = "<?=$proff?>";
}
function donext()
{
	fillform();
	frm.start.value = <?=$start?> + 30;
	frm.submit();
}

function doback()
{
	fillform();
	frm.start.value = <?
		if($start>=30)
			$start-=30;
		else
			$start=0;
		echo $start;
	?>;	
	frm.submit();
}
</script>
<a href="javascript:doback()">Back</a>|<a href="javascript:donext()">Next</a>
<hr>
<?
#include("./searchmore_form.php");
include("./bottom.php");
?>
