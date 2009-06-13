<?php
$dbh=mysql_connect("localhost", "root", "tj18");
mysql_select_db ("genealogy",$dbh);
$uploaddir = 'C:\\www\\Apache\\htdocs\\genealogy\\pics\\';

/*
#phpinfo();
#exec("k:\\windows\\system32\\net.exe start mysql");
#exit;		
#WhatItDoes-	Connects to the specific mysql server, and opened a database.
$retry=2;
while($retry<=0)
{
	$dbh=mysql_connect("localhost", "root", "tj18");
	if(!$dbh)
	{
		echo "Attempting to start the service($retry)...";
		system("k:\\windows\\system32\\net.exe start mysql");
		$retry--;
	}
	else
	{
		mysql_select_db ("genealogy",$dbh);
		$retry=-1;
	}

}
if($retry==0)
{
	die ('I cannot connect to the database because: ' . mysql_error());
}
* */
?>