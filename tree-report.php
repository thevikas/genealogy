<?
$yrs_suffix=false;
include("./common.php");
#import_request_variables("pg","");
$title = "Family Tree";
$cid = cleanvar("cid",0);
include("./top.php");




$level = 0;
function showMarriages($cid,$gender,$name,$level,$isDead,$bpic)
{
	global $high;
	$married=false;

	?>
	<div class="dtable">
	<table border="0" class="level<?=$level?>"><?	
	#20060708
	#1) first list the wife and husband
	
	#$sql = "select w.name as `wife`,h.name as `husband`,m.*,h.treepos as htp,w.treepos as wtp, w.dob as `w_dob`, h.dob as `h_dob`,  w.isDead as `w_dead`, h.isDead as `h_dead`,w.father_cid as `w_father`,h.father_cid as `h_father`,ws.father_root as `w_father_root`,hs.father_root as `h_father_root` from marriages m,persons h,persons w,stats hs,stats ws where hs.cid = h.cid and ws.cid=w.cid and w.cid=wife_cid and h.cid=husband_cid and $cid in (husband_cid,wife_cid) order by w.name";
	$sql = "select w.name as `wife`,h.name as `husband`,m.*,h.treepos as `htp`,w.treepos as `wtp`, w.dob as `w_dob`, h.dob as `h_dob`,  w.isDead as `w_dead`, h.isDead as `h_dead`,h.father_root as `h_root`,w.father_root as `w_root`,h.father_cid as `h_father_cid`,h.bPics as `h_pic`,w.bPics as `w_pic` from marriages m,persons h,persons w where w.cid=wife_cid and h.cid=husband_cid and $cid in (husband_cid,wife_cid) order by w.name";
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
			global $wx;
			?>
			<a href="?cid=<?=$rs1->h_father_cid?>&wx=<?=$wx?>#p<?=$cid?>">Up</a>
			<?	
		}

		if($cid == $rs1->husband_cid)
		{
			?><div class="left_spouse"><?
			
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
		?><tr><td valign="top"><?
		showPersonLink2($cid,$name,$gender,$isDead,0,$bpic);
		$age = getAge($cid,time());
		if($age!="")
			echo " ($age)";
		?></td></tr><?
	}
	?>
	</table>
	</div>
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
@import "grayreport2.css";
</style>

<?
$wx = isset($_GET["wx"]) ? $_GET["wx"] : 0;
if($wx>0)
{
	?>
	<style type="text/css">
	div#box
	{
	width: <?=$wx?>px;
	}

	</style>
	<?
	
}
?>
wx=<?=$wx?>;<a href="?cid=<?=$cid?>&wx=1500">1500px</a>
<a href="?cid=<?=$cid?>&wx=2000">2000px</a>
<a href="?cid=<?=$cid?>&wx=3000">3000px</a>
<a href="?cid=<?=$cid?>&wx=4000">4000px</a>
<input type="text" id="writehere"/>
<div id="box">
<?
echo "<dir>";
$counter = 0;
showFamily($cid);
echo "</dir>";
?>
<h3><?=$counter?></h3>
</div>
<script>
var b = document.getElementById("box");
writehere.value = b.clientWidth + "px X " + b.clientHeight + "px";
var aa = document.getElementsByTagName("a");
i=0;
//alert(aa.length);
for(i=0; i<aa.length;i++)
{
	athis = aa[i];
	if(athis.hasAttribute("cid"))
	{
		athis.setAttribute("onclick","handleperson(event,this,'" + athis.href + "')");
		athis.setAttribute("onmouseover","handleperson(event,this,'" + athis.href + "')");
		//athis.href="javascript:;";
		//athis.href = "haha";
	}
}

function hideEdit()
{
	document.edit_now.sibling.style.display = "inline";
	t2 = document.edit_now.parentNode;
	//alert(t2.removeChild);
	t2.removeChild(document.edit_now);
	document.edit_now  = null;
}

function handleperson(e,t)
{
	//alert(e.ctrlKey + "," + e.altKey + "," + e.shiftKey);
	if(e.ctrlKey)
	{
		if(document.edit_now)
		{
			hideEdit();			
		}
		//alert(t.getAttribute("cid"));
		t.href="#";
		ip = document.createElement("input");
		ip.value = t.innerHTML;
		////visibility="hidden";
		ip.style.width = t.offsetWidth + "px";
		ip.style.borderWidth = "0px";
		ip.cid = t.getAttribute("cid");
		ip.sibling = t;
		ip.setAttribute("onkeyup","dokeyup(event,this)");
		t.style.display="none";
		t.parentNode.insertBefore(ip,t);
		document.edit_now = ip;
		//.appendChild(ip);
		return true;
	}
}

function dokeyup(e,t)
{
	if(e.keyCode == 13)
	{
		changeName(t.cid,t.value);
		hideEdit();	
	}
	else if(e.keyCode == 27)
	{
		hideEdit();	
	}
}

function changeName(cid,new_name)
{		
	//clearTimeout(cdown_timer);
	//debugprinting=yes shows lots of debug data
	//for any purpose, this ajax won't need it.
	var url = "ajax.php?job=1&cid=" + cid + "&name=" + new_name + "&r=" + Math.random();
	
	//alert("url=" + url);
    // branch for native XMLHttpRequest object
    if (window.XMLHttpRequest) {
        xmlobj = new XMLHttpRequest();
        xmlobj.onreadystatechange = processReq;
        xmlobj.open("GET", url, true);
        xmlobj.send(null);
    // branch for IE/Windows ActiveX version
    } else if (window.ActiveXObject) {
        xmlobj = new ActiveXObject("Microsoft.XMLHTTP");
        if (xmlobj) {
            xmlobj.onreadystatechange = processReq;
            xmlobj.open("GET", url, true);
            xmlobj.send();
        }
    }
}

function processReq() {
    if (xmlobj.readyState == 4) {
		// only if "OK"

		if (xmlobj.status == 200) {
			queue_clear=true;
			alert("done");
		}
	}
}
</script>