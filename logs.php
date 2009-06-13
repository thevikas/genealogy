<?
 include("./common.php");
 $title = "View Activity Logs";
 include("./top.php");
 
 $ctr1 = $_GET["ctr1"] + 0;
 $filters = $_SESSION["log_filters"];
 #echo "[$filters]";
 if($filters == "")
 {
	 $filters = ",50,51,52,53,54,55,56,57,58,59,60,";
	 $_SESSION["log_filters"] = $filters;
 }
 $per_page = 50;
 	$sql2="";
 	if($_GET["uid"]>0)
	{
		$sql2 = " and l.uid=" . $_GET["uid"];
	}
	$sql2 = $sql2 . " and ltype in (99 $filters 99)";
	$r = mysql_query("select count(*) as `c` from logs l where 1=1 $sql2",$dbh);
	$row=mysql_fetch_object($r);
	$count = $row->c;
	
	$sql="select l.* from `logs` l where 1=1 $sql2 order by id desc limit $ctr1,$per_page";
	
	#echo $sql;
	$r = doquery($sql,$dbh);
	?>
	
	<a href="clearlog.php">Clear Logs</a>
	

	<table border=0 width="100%">
	<tr class="head">
		<td class="thead">LogType</td>
		<td class="thead">UID</td>
		<td class="thead">Timestamp</td>
		<td class="thead">Params</td>
	</tr>
	<?
	if(mysql_num_rows($r) == 0)
	{
		?><tr><td>No log entried for this request.</td></tr><?
	}
	while($row = mysql_fetch_object($r))
	{
		$t=strtotime($row->dated);
		?><tr>
			<td><b><?=logType2String($row->ltype) . "(" . $row->ltype . ")" ?></b></td>
			<td><a href="?uid=<?=$row->uid;?>"><?=$row->name?></a></td>
			<td><?=date(s_strftime,$row->dated);?></td>
			<td><?=$row->param;?>;
			<font color="blue"><?
			echo showLogEntryDetails($row->ltype,$row->param);
			?></font>
			</td>
			</tr><?;
	}
?></table>
</td></tr>
<tr><td>

<table width="100%" border=0><tr><td>
<? if($ctr1>0) { 
?><a href="<? echo "?fuid=$fuid&ctr1=" . max(0,($ctr1 - $per_page)) ?>&uid=<?=$uid?>	">Prev</a><?
}
$ctr1+=$per_page;
?></td><td align=right><?
	if($ctr1<$count) { ?>
	<a href="<? echo "?fuid=$fuid&ctr1=$ctr1&uid=$uid" ?>">Next</a>
 <?
 }
 ?>
</td></tr></table>

</td>
</tr>
<tr>
<td>
<hr>
<table border=0>
<tr>
<form action="filter2.php" method=post>
<?
for($ctr=50; $ctr <NEXT_LOG; $ctr++)
{
	if($ctr % 7 == 0) echo "</tr><tr>";
	$checked="";
	if(strpos(",$filters",",$ctr,")==true) $checked="checked";
	?><td><input <?=$checked?> type="checkbox" name="types[]" value="<?=$ctr?>" id="type<?=$ctr?>">
	<label for="type<?=$ctr?>"><?echo logType2String($ctr) ?></label></td><?
}
?></tr>
<tr>
<td colspan=7 align=right>
<input type="submit" value="Apply">
</td></form>
</tr>
</table>

</td></tr>
</table>

<?
include("./search_form.php");
 include("./bottom.php") ?>

