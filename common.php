<?php
ini_set('short_open_tag','On');
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 'on');
require_once("./constants.php");
require_once("clsPerson.php");
#ob_start("ob_gzhandler");
header("Cache-Control: no-store, no-cache, must-revalidate");
$safe=true;
session_start();
include("db.php");
$onLoad=false;
$showsearch=true;

if(isset($_SESSION["oid"]))
	$oid=$_SESSION["oid"];
if(isset($_SESSION["oname"]))
	$oname=$_SESSION["oname"];
$showlink2_detail=false;
if(!isset($yrs_suffix) || $yrs_suffix=="")
	$yrs_suffix = true;
/* ADDING A NEW LOG HOOK - HowTo - 200504230843
 * There are 4 files that need a change for a new log hook.
 * The changes are describes here step by step.
 * 1)constants.php
 * 	go to end of file and define a new constant with 1 more than
 *  last constant value. also provide a timestamp. record the new
 *  number for use in the next file change.
 * 2)common.php
 * 	it will have 2 changes.
 *  a) a new case entry in logType2String for a new ID
 *  b) modification of entry in NEXT_LOG constant
 * 3)logs.php
 * 	there is a default filter array declaration which now needs a
 *  number in it's like string terminated by a comma like the last one.
 * 4)actual file to be hooked!
 * 	add logthis(with the contant id in the first change,any params ids)
 * optional)logs.php
 * 	each log entry has a specific param ids. conversion of that comma
 *  delimitted ids to a descriptive string could also be done. this
 *  converted string gets displayed in the log viewer.
 * After these changes new entry will fit in correctly in the existing
 * framework of log viewer with filter support.
 */

/* 200503270629:
 * template support; by default submit_tariff will write
 * moreF and moreG fields in the form it generates.
 * The other 2 submit_tariff_moreX variables also also related
 * to same subject. just initing them here with zeros.
 */
$dump_more = true;
$submit_tariff_moreG = 0;
$submit_tariff_moreF = 0;

define("CLEARLOG",0);
define("NEXT_LOG",70);

define("s_strftime", "Y-m-d");

function doquery($sql,$ln=0,$die_on_error=1)
{
	global $debugprinting;
	global $debug_dump;
	global $last_mysql_error;
	global $last_mysql_errno;
	if($debugprinting)
		echo "<!-- doquery($sql) -->\n";

	#causes memory failure. halted for now
	#200711161226
	#$debug_dump .= "<font class=query>doquery($sql) /* line $ln */</font>\n";

	global $dbh;
	$result = $dbh->query($sql);

	if($last_mysql_errno = $dbh->errno)
	{
		$errstr = $last_mysql_error = $dbh->error;
		global $debug_dump;
		$e_out = "<font color=red>$errstr</font> at line $ln (" . session_id() . ")<br/>";

		//200707311800
		#$e_out = "\n<hr/>\n" . var_export(debug_backtrace(),true);
		$debug_dump .= $e_out;

		if($debugprinting || 1)
		{
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/v2.css\" />";
			echo "<div class='sql_error'>" . $errstr . "</div>";
			echo "<div class='sql'>$sql</div>";
			echo "<p class='backtrace'>";
			debug_print_backtrace();
			echo "</p>";
		}
		$errstr = quotemeta($errstr);
		logthis("v2-doquery-FAILED",$errstr);
		if($die_on_error)
			exit;
		else
			return false;
	}

	return $result;
}

function makeNiceDate($d,$m,$y)
{
	if($d==0 || $m==0 || $y==0)
		return "";
	return $d . "-" . mon2str($m) . "-" . $y;
}
function showNiceDate($dt)
{
	$dt2 = strtotime("" . $dt);
	return date("D, M j",$dt2);
}

function mon2str($i)
{
	switch($i)
	{
		case 1:
			return "Jan";
		case 2:
			return "Feb";
		case 3:
			return "Mar";
		case 4:
			return "Apr";
		case 5:
			return "May";
		case 6:
			return "Jun";
		case 7:
			return "Jul";
		case 8:
			return "Aug";
		case 9:
			return "Sep";
		case 10:
			return "Oct";
		case 11:
			return "Nov";
		case 12:
			return "Dec";
	}
}


function doInit($full = 0)
{
	//return; //201011291222:vikas:doinit is now off
	$r1 = doquery("select * from persons order by updated desc limit 0,10");
	while($rs1 = mysqli_fetch_object($r1))
	{
		$cid = $rs1->cid;
		doInit_cid($cid,$rs1);
	}
	if($full)
		doInit_Dates();
}


#200507251210:vikas:working out the closest posible event in current time
function doInit_Dates()
{
	#initialize the display
	 $sql = 'SELECT cid,dob as `d`,1 as `etype` FROM `persons` WHERE dob<>\'0000-00-00\''
        . ' union'
        . ' SELECT cid,dod as `d`,2 as `etype` FROM `persons` WHERE dod<>\'0000-00-00\''
        . ' union'
        . ' SELECT husband_cid as `cid`,dom as `d`,3 as `etype` FROM `marriages` WHERE dom<>\'0000-00-00\''
        . ' union'
        . ' SELECT wife_cid as `cid`,dom as `d`,3 as `etype` FROM `marriages` WHERE dom<>\'0000-00-00\'';
	$r1 = doquery($sql);
	doquery("truncate table eventdates");
	echo "<p>";
	while($rs = mysqli_fetch_object($r1))
	{
    /*
	* [seconds] => 40
	* [minutes] => 58
	* [hours]   => 21
	* [mday]    => 17
	* [wday]    => 2
	* [mon]     => 6
	* [year]    => 2003
	* [yday]    => 167
	* [weekday] => Tuesday
	* [month]   => June
	* [0]       => 1055901520
	*/
		$thisyear = 2005;
		#echo $d["year"];
		$etype = $rs->etype;
		$cid = $rs->cid;
		#echo "CID: $cid: ($rs->d) ";
		#$d = getdate(strtotime($rs->d));
		list($year,$mon,$day1) = explode("-",$rs->d);
		list($day,$time1) = explode(" ",$day1);
		do
		{
			#echo "\n<!--- mktime(0, 0, 0, $mon, $day,$thisyear); -->";
			$dated=mktime(0, 0, 0, $mon, $day,$thisyear);
			$thisyear++;
		} while($dated <time());

		$d = getdate($dated);
		$year = $d["year"];
		$mon = $d["mon"];
		$day=$d["mday"];

		$sql = "insert into eventdates(cid,dated,etype) values($cid,'$year-$mon-$day',$etype)";
		#echo $sql;
		doquery($sql);
		#echo date(s_strtime,$dated);
		#echo "<br/>";
		#exit;
		#getdate();
	}

}


function doInit_cid($cid,$rs1)
{
	$name = $rs1->firstname . " " . $rs1->lastname;
	$sql="update persons set name='$name' where cid=$cid";
	doquery($sql);
}

function addMRU($cid)
{
	global $oid;
	$sql="update mru set dated=now() where cid=$cid";
	#echo $sql;
	doquery($sql);
	if(mysql_affected_rows()==0)
		doquery("insert into mru(cid,dated) values($cid,now())");
}

function getPhones($rs)
{
	return $s;
}

#200503090021
function logThis($ltype,$param)
{
	global $oid;
	$oid=0;
	doquery("insert into logs(uid,ltype,dated,param) values($oid,$ltype,now(),'$param')");
}

function logType2String($t)
{
    switch ($t) {
case ADDSPOUSEMAN:
	return "AddManSpouse";
	break;
case ADDSPOUSEMAN:
	return "AddWomanSpouse";
	break;
case SETFATHER:
	return "SetFather";
	break;
case SETMOTHER:
	return "SetMother";
	break;
case ADDCHILD:
	return "AddChild";
	break;
case ADDPARENT:
	return "AddChild";
	break;
default:
    return "U:$t";
    }
}


function getPersonName($cid)
{
	if(strlen($cid)<1 || $cid==0)
		return "N/A";

	$sql = "select * from persons where cid=$cid";

	$rt = doquery($sql);
	$rs = mysql_fetch_object($rt);
	if($rs)
		return $rs->firstname . " " . $rs->lastname;
	else
		return "Invalid CID(" . $cid . ")";
}

function getPerson($cid)
{
	$sql = "select * from persons where cid=$cid";
	$rt = doquery($sql);
	$rs = mysql_fetch_object($rt);
	return $rs;
}

function showLogEntryDetails($lt,$param)
{
	switch($lt)
	{
		case 8:
		case 9:
			return "<a style=\"color:#5f5fff\" href=\"opencost.php?qid=$param\">" . getPersonName($param,1) . "</a>";
		case 5:
			return "<a style=\"color:#5f5fff\" href=\"openperson.php?cid=$param\">" . getPersonName($param,0) . "</a>";
		case 3:
			return "<a style=\"color:#5f5fff\" href=\"openperson.php?cid=$param\">" . getPersonName($param,0) . "</a>";
		case 12:
		case 7:
			return "<a style=\"color:#5f5fff\" href=\"openperson.php?cid=$param\">" . getPersonName($param,1) . "</a>";
	}
}

function unescape($str)
{
	$str = str_replace("\\\'","\'",$str);
	return $str;
}

#200504230807 - templates don't need any costing details with them.
function resetTemplates() {
	$sql = 'UPDATE `query_tariff` SET'
        . ' `cost_kids` = 0,'
        . ' `cost_adults` = 0,'
        . ' `cost_discount` = 0,'
        . ' `cost_total` = 0,'
        . ' `cost_singles` = 0,'
        . ' `cost_triples` = 0,'
        . ' `plan` = \'\','
        . ' `dated` = NOW( ) WHERE `cid` = \'' . TEMPLATECID . '\'';
	#echo $sql;
	doquery($sql);
}


function showParent($cid,$gender,$child_cid)
{
	if($gender)
		echo "Father:";
	else
		echo "Mother:";
	$name = getPersonName($cid);
	#echo $cid . "name=" . $name;
	#exit;
	if($name == "N/A")
	{
		?>
		<form action="addparent.php">
		<input type="hidden" name="cid" value="<?=$child_cid?>">
		<input name="gender" type="hidden" value="<?=$gender?>">
		<input type="text" name="name">
		<input type="submit" value="Add">
		</form>
		<?php
	}
	else
	{
		showPersonLink($cid,$name,$gender);echo "<br/>";
	}
}

#200507021951
function listFamily($cid,$gender,$father,$mother)
{
	global $addchild_sel;

	#200804130940:vikas:php5 change to code to support old function
	$addchild_sel = cleanvarg("addchild_sel",2);

	#list father and mother
	showParent($father,1,$cid);
	showParent($mother,0,$cid);

	if($father>0 && $mother>0)
	{
	#list siblings
	$r4 = doquery("select name,gender,cid from persons where father_cid=$father and mother_cid=$mother and cid<>$cid");
	while($rs4=mysql_fetch_object($r4))
	{
		?><li><?=$rs4->gender ? "Brother" : "Sister"?>:<?php
		showPersonLink($rs4->cid,$rs4->name,$rs4->gender);
	}
	?>
			<form name="addsibling" action="addchild.php">
			<input type="hidden" name="father_cid" value="<?=$father?>">
			<input type="hidden" name="mother_cid" value="<?=$mother?>">
			<input type="hidden" name="cid" value="<?=$cid?>"><br/>
			<br/>
			Add Sibling: <input type="text" name="name">
			<select name="gender"><option value="1">Brother</option>
			<option value="0">Sister</option></select>
			<input type="submit" value="Add">
			</form>
	<?php
	}
	if(strlen($addchild_sel)==0) $addchild_sel = 2;
	$r1 = doquery("select h.name as `husband`,w.name as `wife`,m.* from marriages m,persons h,persons w where w.cid=m.wife_cid and h.cid=m.husband_cid and $cid in (wife_cid,husband_cid)");
	#go through all marriages
	while($rs1=mysql_fetch_object($r1))
	{
		#list spouse name
		?><br/><br/>Spouse: <?php
		if($gender==1)
			showPersonLink3($rs1->wife_cid,$rs1->wife,0,$cid);
		else
			showPersonLink3($rs1->husband_cid,$rs1->husband,1,$cid);

		?>
		<form action="dom.php" method="post">
		Date of Marriage (yyyy-mm-dd): <input size="12" type="text" name="dom" value="<?=$rs1->dom?>">
		<input type="hidden" name="mid" value="<?=$rs1->mid?>">
		<input type="hidden" name="cid" value="<?=$cid?>">
		<input type="submit" value="Save">
		</form>
		<dir>
		<?php

		$r2=doquery(
			"select * from persons where father_cid=" . $rs1->husband_cid .
			" and mother_cid=" . $rs1->wife_cid);
		while($rs2=mysql_fetch_object($r2))
		{
			echo "<li>";
			showPersonLink($rs2->cid,$rs2->name,$rs2->gender);
			echo "</li>";
		}
		?></dir>
			<form name="addchild" action="addchild.php">
			<input type="hidden" name="father_cid" value="<?=$rs1->husband_cid?>">
			<input type="hidden" name="mother_cid" value="<?=$rs1->wife_cid?>">
			<input type="hidden" name="cid" value="<?=$cid?>">
			<br/><br/>
			Child Name: <input type="text" name="name" value="NoName" onfocus="this.select()">
			<select name="gender">
			<option value="1" <?=floor($addchild_sel)==1 ? "selected" : ""?>>Son</option>
			<option value="0" <?=floor($addchild_sel)==0 ? "selected" : ""?>>Daughter</option></select>
			<input type="submit" value="Add">
			</form>
		<?php
	}
}

#200507022047
function addPerson($name,$gender,$father,$mother)
{
	$father = $father==0 ? "null" : $father;
	$mother = $mother==0 ? "null" : $mother;
	$name = rtrim(ltrim($name));
	$a = explode(" ",$name);
	$fn="";
	for($i=0; $i<count($a)-1;$i++)
		$fn .= $a[$i] . " ";
	$ln = $a[count($a)-1];
	$fn = rtrim(ltrim($fn));
	$sql = "insert into persons(firstname,lastname,gender,father_cid,mother_cid) values('$fn','$ln',$gender,$father,$mother)";
	#echo $sql;
	#exit;
	doquery($sql);
	$rt = mysql_insert_id();
	doInit();
	return $rt;
}

function addSpouseForm($cid,$def,$child_cid)
{
	?>
	<form name="addspouse" action="addspouse.php" method="post">
	<br/>
	Add Spouse: <input type="text" value="<?=$def?>" name="spouse"><input value="Add" type="submit"><br/>
	<input name="cid" value="<?=$cid?>" type="hidden">
	<input name="child_cid" value="<?=$child_cid?>" type="hidden">

	</form>
	<?php
}

function redirect($url)
{
	?>
	<script type="text/javascript">
	window.location = "<?=$url?>";
	</script>
	<?php
}

function showPersonLink($cid,$name,$gender)
{

	?>
	<img src="imgs/<?=$gender==1 ? "man" : "woman" ?>_icon.gif" width="<?=$gender==1 ? "8" : "10" ?>" height="15">
	<?php
	$yrs=0;
	$spouse = isMarried($cid,$gender,$yrs);
	if($spouse>0)
	{
		?>
		<img src="imgs/marriage.gif" width="15" height="15">
		<?
		if($yrs>0)
			echo "(" . $yrs . ")";
		?>
		<a href="openperson.php?cid=<?=$spouse?>"><img
		 src="imgs/<?=$gender==0 ? "man" : "woman" ?>_icon.gif" border="0" width="<?=$gender==0 ? "8" : "10" ?>" height="15"></a>
		<?php
	}
	?>
	<a name="cid<?=$cid?>" href="openperson.php?cid=<?=$cid?>"><?=$name?></a> <?php
	echo getAge($cid);
	if(isset($noedit) && $noedit=="1")
	{
		?><A href="editperson.php?cid=<?=$cid?>">[Edit]</a><?php
	}

}

function strtotime2($tm)
{
	#echo $tm;
	list($year,$mon,$day) = split("-",$tm);
	#echo $year;
	#exit;
	return floor($ss[0])*946728000+floor($ss[1])*2592000+floor($ss[2])*86400;
}
function getAge($cid)
{
	$rs = getPerson($cid);
	#echo "[$rs->dob]";
	#exit;
	return getYearsCount($rs->dob,time());
}

function getYearsCount($dt1,$dt2)
{
	global $yrs_suffix;
	$yrs_string = ($yrs_suffix ? "yrs" : "");
	$s2t = strtotime($dt1 . " ");
	#echo "[$dt1]";
	#exit;

	list($year,$mon,$day) = explode("-",$dt1);
	#echo  $dt1 . ";" . $s2t . ";" . $year2 . "-" . $year . "yrs";
	#exit;
	if($year<=1970 && floor($year)>0)
	{
		list($year2,$mon2,$day2) = explode("-",date(s_strftime,$dt2));
		return $year2-$year . $yrs_string;
	}
	$diff = time() - $s2t;
	if($s2t == 943900200 || floor($year)==0)
		return "";
	$diff /= 31557600;
	return round($diff) . $yrs_string;
}

function showPersonLink3($cid,$name,$gender,$spouse_cid)
{
	showPersonLink($cid,$name,$gender);
	?> <A href="deletemarriage.php?cid=<?=$cid?>&spouse_cid=<?=$spouse_cid?>">[Delete Spouse]</a><?php
}

function showPersonLink2($cid,$name,$gender,$dead,$hroot,$pic)
{
	global $counter;
	$counter++;
	global $showlink2_detail;
	if($showlink2_detail)
		return showPersonLink($cid,$name,$gender);
	$name = str_replace("Yadav","",$name);

	?>
	<img src="imgs/<?=$dead ? "dead_" : "" ?><?=$gender==1 ? "man" : "woman" ?>_icon.gif" width="<?=$gender==1 ? "8" : "10" ?>" height="15">
	<a name="p<?=$cid?>" cid="<?=$cid?>" href="openperson.php?cid=<?=$cid?>"><?=$name?></a><?php
	#if father_root is different from father_cid then show the pointer
	if($pic>0)
	{
		?><sup>p</sup><?php
	}
	if($hroot>0)
	{
		?><sup><a href="tree-report.php?cid=<?=$hroot?>#p<?=$cid?>">(!)</a></sup><?php
	}
}

//200510032218:vikas:exporting puposes
function showPersonLink_export($cid,$name,$gender,$spouse_id,$father_id,$mother_id)
{
	global $showlink2_detail;
	?><?=$cid?>:<?=$gender==1 ? 0 : 1 ?>:<?=$name?>:<?=$spouse_id?>:<?=$father_id?>:<?=$mother_id?><?php
	echo "\n";
}

function isMarried($cid,$gender,&$yrs)
{
	$sql = "select * from marriages where $cid in (husband_cid,wife_cid)";
	#echo $sql;
	$r1=doquery($sql);
	$rs1 = mysql_fetch_object($r1);
	if(!$rs1)
		return 0;
	$yrs = getYearsCount($rs1->dom,time());
	#echo "m=$yrs";
	if($gender==1)
		if($rs1->wife_cid)
			return $rs1->wife_cid;
		else
			die("Invalid Marriage record!");
	else
		if($rs1->husband_cid)
			return $rs1->husband_cid;
		else
			die("Invalid Marriage record!");
}

#200507190824
function getPic($cid,$width,$height)
{
	$rs1 = doquery("select * from pics where cid=$cid and name='main'");
	$rs = mysql_fetch_object($rs1);
	$name = "c" . $cid . ".jpg";
	if($width==0)
	{
		$width = $rs->width;
		$height = $rs->height;
	}
	else
	{
		$height="";
	}
	$s = "<div class=\"picbox\"><A href=\"pics/$name\"><img src=\"pics/$name\" width=\"$width\" height=\"$height\"></a>";
	$rs1 = doquery("select * from pics where cid=$cid and name<>'main'");
	while($rs = mysql_fetch_object($rs1))
	{
		$pid = $rs->pid;
		$s .= "<img class=\"picinbox\" width=\"50\" src=\"pics/$pid.jpg\">";
	}


	#if no addional pics, we close the tag
	$s .= "</div>";
	return $s;
}

#200711261643:vikas:came from LH.com
function cleanvarp($var,$el)
{
	return isset($_POST[$var]) ? $_POST[$var] : $el;
}

#200711261643:vikas:came from LH.com
function cleanvarg($var,$el)
{
	return isset($_GET[$var]) ? $_GET[$var] : $el;
}

#200711261643:vikas:came from LH.com
#20071016-bug#103:generic fuction to scan either GET or POST automatically
#made for first use at /students/packageCode.php
function cleanvar($var,$el)
{
	return isset($_REQUEST[$var]) ? $_REQUEST[$var] : $el;
}
?>
