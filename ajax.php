<?

session_start();
$debugprinting=0;
require_once("./common.php");

$job = intval($_GET["job"]);

global $debugprinting;
$debugprinting=1;
//--------2----------
if($job==1) #change name
{
	$cid =  $_GET["cid"];	
	$ss = explode(" ",$_GET["name"] . " ");

	$firstname = $ss[0];
	$lastname = '$lastname';
        $lastname = $ss[1];

	doquery("update persons set updated=now(),lastname='$lastname',firstname='$firstname' where cid=$cid");
}
if($job==2) #new childs
{
	$gender =  $_GET["gender"];	
	$mcid =  $_GET["mcid"];	
	$fcid =  $_GET["fcid"];	
	$ss = explode(" ",$_GET["name"] . " ");

	$firstname = $ss[0];
	$lastname = '$lastname';
        $lastname = $ss[1];

	doquery("insert into persons set updated=now(),lastname='$lastname',firstname='$firstname',gender=$gender,father_cid=$fcid,mother_cid=$mcid");
}
if($job==3) #spouse
{
	$gender =  $_GET["gender"];	
	$spousecid =  $_GET["cid"];	
	$ss = explode(" ",$_GET["name"] . " ");

	$firstname = $ss[0];
	$lastname = '$lastname';
        $lastname = $ss[1];

	doquery("insert into persons set updated=now(),lastname='$lastname',firstname='$firstname',gender=$gender");

	if($gender)
	{
		$husband_cid = mysql_insert_id();
		$wife_cid = $spousecid;
	}
	else
	{
		$wife_cid = mysql_insert_id();
		$husband_cid = $spousecid;
	}

	doquery("insert into marriages set husband_cid=$husband_cid,wife_cid=$wife_cid");

}
doInit();
?>
