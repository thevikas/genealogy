<?php

?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="querystyle.css"/>
</style>
<title><?= $title ?></title>
</head>
<body<? if ($onLoad) echo " onload=\"ol()\"";?>>
<div id="topbox">
<div style="display: inline;background-color: #afafff;padding: 1px;"><b><?= $title ?></b></div>
<br/>
[<a href="./">Home</a>]
[<a href="editperson.php?cid=-1">New Person</a>]
[<a href="events.php">Events</a>]
[<a href="analyse.php">Analyse</a>]
[<a href="http://gene.local:222/tree-report.php?cid=33">Tota Ram</a>]

<?
$rm = doquery("select * " .
		" from mru,persons c where c.cid=mru.cid and deleted=0 order by mru.dated desc limit 20");
$f2=false;
while($rsm = mysql_fetch_object($rm))
{
	if(!$f2) {
	?>
	
	<table style="display: inline; position:absolute; left: 600px; top: 0px;background-color: orange;padding: 2px;">
	<tr><form action="openperson.php"><td>
	<select name="cid" onchange="this.form.submit();">
	<option>(recent persons)</option>
	<?
	}
	$f2=true;
	$name = $rsm->firstname . " " . $rsm->lastname;
	$cls = "class=\"mruoption\"";
	
	if($rsm->bookings > 0)
	{
		$cls = "class=\"mrubooked\"";
		if($rsm->book_paid>0)
			$cls = "class=\"mrupaid\"";
	}
	else if($rsm->tariff > 0)
	{
		$cls = "class=\"mrutariff\"";
	}
	$cidT = $rsm->cid;
	echo "<option $cls value=\"$cidT\">$name</option>";
}
if($f2)	echo "</select></td></tr></form></table>";

?>
<hr>
</div>