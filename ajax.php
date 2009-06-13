<?

session_start();
$debugprinting=0;
require_once("./common.php");

$job = intval($_GET["job"]);

//--------2----------
if($job==1) #change name
{
	$cid =  $_GET["cid"];	
	$firstname = $_GET["name"];
	doquery("update persons set firstname='$firstname' where cid=$cid");
}
?>