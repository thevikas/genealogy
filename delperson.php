<?
include("./common.php");
#include("./top.php");
import_request_variables("pg","");
$prompt = "Are you sure you wish to delete the record of ";
$tablename = "persons";
$idname = "cid";
if(strlen($tname)>0)
{
	$tablename = $tname;
	$idname = $idn;
	$prompt .= " the operator";
}
else
{
	$prompt .= "<b>" . getPersonName($id) . "</b>";
}

if($confirm!=1)
{
	echo $prompt . "?";
	?>
	<A href="?idn=<?=$idn?>&id=<?=$id?>&tname=<?=$tname?>&confirm=1">[Yes]</a>
	<A href="javascript:history.go(-1);">[No]</a>
	<?
	exit;
}

doquery("delete from $tablename where $idname=$id");
doquery("delete from marriages where $id in (wife_cid,husband_cid)");
logThis(DELETEPERSON,$id);
?>
	<script>
	window.location = "index.php";
	</script>
<?
include("./bottom.php");
?>