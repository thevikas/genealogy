<?
include("./common.php");
//200503270534
//TEMPLATECID is a special customer who only has collection of itineraries
//these are called and used in other persons. thats all.

$cid = cleanvarg("cid",0);
$sql="select * from persons where cid=$cid";
$r = doquery($sql);
$rs=$r->fetch_object();
$title = "Summary - " . $rs->firstname . " " . $rs->lastname;
addMRU($cid);
logThis(SUMMARY,$cid);
include("./top.php");

?>
<b>[<a href="editquery.php?qid=-1&cid=<?=$cid?>">New Query</a>]</b>
[<a href="editperson.php?cid=<?=$cid?>">Edit Person</a>]
[<a href="delperson.php?id=<?=$cid?>">Delete Person</a>]
[<a href="upload.php?cid=<?=$cid?>">Upload Pics</a>]
[<a href="report.php?cid=<?=$cid?>">Report</a>]
[<a href="tree-report.php?cid=<?=$cid?>">Tree Report</a>]
[<a href="circlechart.php?cid=<?=$cid?>">Circular Chart</a>]
<p></p>

<? if($rs->bPics)
	echo getPic($cid,150,0); ?>

<table bgcolor="#00afaf" width="80%" cellspacing=1 cellpadding=2 border="1">
<tr bgcolor="#afefef">
<td class="fieldname">Name:</td><td colspan="3" class="fieldvalue"><?=$rs->firstname?>
&nbsp;<?=$rs->lastname?><?
if($rs->isDead) echo " (expired)";
?></td>
<td class="fieldname">Gender:</td>
<td class="fieldvalue"><?=$rs->gender == 1 ? "Male" : "Female"?>
</td>
</tr>
<tr bgcolor="#afefef">
<td class="fieldname">DOB:</td>
<td class="fieldvalue"><?=$rs->dob?>
<td class="fieldname">Age:</td>
<td class="fieldvalue"><?
echo getAge($cid);
?>
</td>
<td class="fieldname">DOD:</td>
<td class="fieldvalue"><?=$rs->dod?>
<form action="hasexpired.php" method="post">
<input type="submit" value="Has Expired">
<input type="hidden" name="cid" value="<?=$cid?>">
</form>
</td>
</tr>
<TR>
<td bgcolor="#afefef" colspan="6">
<form action="addcomment.php" method="post">
<textarea name="newcomment" rows="2" style="width:100%"></textarea>
<input type="submit" value="Add Comments">
<input type="hidden" name="cid" value="<?=$cid?>">
</form>
</td>
</TR>
</table>
<br/>
<br/>
<?
#search for marriages and display here.
listFamily($cid,$rs->gender,$rs->father_cid,$rs->mother_cid);
#if none found, show a textbox to add spouse name
#which ads a marriage and a contact
?>
<br/>
<?
addSpouseForm($cid,"NoName",0);
?>
<script>
//alert(window.location.search);
if(window.location.search.indexOf('addchild_sel')>0)
	document.forms["addchild"].name.focus();
</script>
<?
include("./search_form.php");
include("./bottom.php");
?>
