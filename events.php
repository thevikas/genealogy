<?
include("./common.php");

import_request_variables("pg","");
$title = "Events - Birthdays/etc";
include("./top.php");
$sql = 'SELECT p.name,f.name as `father`,m.name as `mother`,p.father_cid,p.mother_cid,e.dated,etype FROM `eventdates` as `e`,persons as `p`,persons as `f`,persons as `m` where m.cid=p.mother_cid and f.cid=p.father_cid and e.cid=p.cid order by e.dated';
$r1 = doquery($sql);
?>
<style type="text/css">
.col1 {
	display: inline;
	float: left;
	clear:left;
	width: 150px;
	/*border: solid 1px red;*/
}
.col2 {
	float: left;
	width: 150px;
	display: inline;
}
.col3 {
	float: left;
	width: 150px;
	display: inline;
}
</style>

<div style="font-weight:bold" class="col1">Name</div>
<div style="font-weight:bold" class="col2">Father</div>
<div style="font-weight:bold" class="col2">Mother</div>
<div style="font-weight:bold" class="col2">Date</div><br/>

<?
while($rs = mysql_fetch_object($r1))
{
	?>
	<div class="col1"><?=$rs->name?></div>
	<div class="col2"><?=$rs->father?></div>
	<div class="col2"><?=$rs->mother?></div>
	<div class="col2"><?
		echo strtotime($rs->dated) . " , " . time();
		$diff = strtotime($rs->dated) - time();
		$hours = $diff/60*60;
		echo $hours;
		
	?></div>
	<div class="col2"><?=$rs->dated?></div>
	<div class="col3"><?
	 switch($rs->etype)
	 {
	 	case 1:
			echo "Birthday";
			break;
		case 2:
			echo "Death Anniversary";
			break;
		case 3:
			echo "Marriage Anniversary";
			break;
	 }
	 ?></div><br/>
	<?		
}
?>
<?
include("./search_form.php");
include("./bottom.php");
?>
