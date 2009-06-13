<?
include("./common.php");
/* Add New Field How To
 * --------------------
 * 1) Add field in MySQL persons table
 * 2) give a name to the INPUT field
 * 3) add field in record set loaders
 * 4) country field in update SQL
 * 5) add field loaders in openperson
 * 6) add field display in openperson
 */
import_request_variables("pg","");
if($post==1)
{
	if($cid==-1)
	{
		doquery("insert into persons(firstname) values('newr')");
		$cid = mysql_insert_id();
		logThis(NEWPERSON,"$cid");
	}
	else
		logThis(EDITPERSON,"$cid");
	doquery("update persons set gender='$gender',firstname='$firstname',lastname='$lastname' where cid=$cid");
	doquery("update persons set dob='$dob',dod='$dod',address='$address' where cid=$cid");
	doInit();
	if($rush==1)
	{
		?>
		<div style="display:none">
		<form method="post" name="queryform" action="editquery.php">
		<?
		include("./query_form.php");
	?>
	<input type="hidden" name="cid" value="<?=$cid?>">
	<input type="hidden" name="rush" value="1">
	<input type="hidden" name="post" value="1">
	</form>
	</div>
	<?
	
	}
	else
	{
	?>
	<script>
	window.location = "openperson.php?cid=<?=$cid?>";
	</script>
	<?
	}

	
	exit;
}
if($cid>0)
{
	$sql="select * from persons where cid=$cid";
	$r = doquery($sql);
	$rs=mysql_fetch_object($r);
	$firstname = $rs->firstname;
	$lastname = $rs->lastname;
	$gender = $rs->gender;
	$dob = $rs->dob;
	$dod = $rs->dod;
	$address = $rs->address;
}
else
{
	$title = "New Person";
}

$onLoad = true;
include("./top.php");

if($cid>0)
{
?>
<p>
[<a href="openperson.php?cid=<?=$cid?>">Summary</a>]
[<a href="delperson.php?id=<?=$cid?>">Delete</a>]</p>
<?}?>
<form method="post" action="editperson.php" name="editperson">
<?

$textbox_dims = " rows=5 cols=100 ";
?>

<table bgcolor="#00afaf"  cellspacing=1 cellpadding=2 border="0">
<tr bgcolor="#afefef">
<td class="fieldname">First Name:</td><td class="fieldvalue"><input maxlength="250" class="editinput" size="40" type="text" value="<?=$firstname?>" name="firstname"></td>
</tr>
<tr bgcolor="#afefef">
<td class="fieldname">Last Name:</td><td class="fieldvalue"><input maxlength="250" class="editinput" type="text" value="<?=$lastname?>" name="lastname"></td>
</tr>
<tr bgcolor="#afefef">
<td class="fieldname">Gender:</td><td class="fieldvalue"><select
 name="gender"><option
  <?
  if($gender==1) echo "selected"?> value="1">Male</option>
  <option
  <?
  if($gender==0) echo "selected"?> value="0">Female</option></select></td>
</tr>
<tr bgcolor="#afefef">
<td class="fieldname">Date Of Birth (YYYY-MM-DD):</td>
<td class="fieldvalue"><input maxlength="250" class="editinput"
 type="text" value="<?=$dob?>" name="dob"></td>
</tr>
<tr bgcolor="#afefef">
<td class="fieldname">Date Of Death (YYYY-MM-DD):</td>
<td class="fieldvalue"><input maxlength="250" class="editinput"
 type="text" value="<?=$dod?>" name="dod"></td>
</tr>
<tr bgcolor="#afefef">
<td class="fieldname" valign="top">Address:</td>
<td class="fieldvalue"><input type="text" name="address" value="<?=$address?>"></td>
</tr>
<tr bgcolor="#afefef">
<td class="fieldname" valign="top">Comments:</td>
<td class="fieldvalue"><textarea name="comments" <?=$textbox_dims?>><?#=$comments?></textarea></td>
</tr>
<tr bgcolor="#afefef"><td colspan="8"><input type="submit" value="Save"></td></tr>
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" name="post" value="1">
</form>
</table>
<hr>
<?
include("./search_form.php");

include("./bottom.php");
?>