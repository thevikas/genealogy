<?
include("./common.php");
import_request_variables("pg","");
$title = "Events - Birthdays/etc";
$sql = 'SELECT p.name,f.name as `father`,m.name as `mother`,p.father_cid,p.mother_cid,e.dated,etype FROM `eventdates` as `e`,persons as `p`,persons as `f`,persons as `m` where m.cid=p.mother_cid and f.cid=p.father_cid and e.cid=p.cid order by e.dated';
$r1 = doquery($sql);
header("Content-Type: text/plain");
#header("Content-disposition: attachment; filename=yahoo.csv");
?>"Subject";"Start Date";"Start Time";"End Date";"End Time";"All day event";"Description"
<?
while($rs = mysql_fetch_object($r1))
{
	//"11/11/2001"
	?>"<?=$rs->name?>'s Birthday";"<?=date("d/n/Y",strtotime($rs->dated))?>";"";"";"";"true";"<?=$rs->name?> of <?=$rs->father?> and <?=$rs->mother?>"
<?
}
?>