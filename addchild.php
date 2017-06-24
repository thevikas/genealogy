<?
include("./common.php");
$name = mysql_escape_string(cleanvar("name",""));
$gender = mysql_escape_string(cleanvar("gender",""));
$father_cid = mysql_escape_string(cleanvar("father_cid",""));
$mother_cid = mysql_escape_string(cleanvar("mother_cid",""));
$newcid=addPerson($name,$gender,$father_cid,$mother_cid);
logThis(ADDCHILD,$newcid);

if(!isset($_SESSION["init_called"]))
{
	doInit();
	$_SESSION["init_called"]=1;
}

#200507270756:vikas:added gender default selection option
header("Location: openperson.php?cid=$father_cid&addchild_sel=$gender");
?>