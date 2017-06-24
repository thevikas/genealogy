<?php
$uploaddir = '/home/sangla/public_html/thevikas/gene/pics/';

#WhatItDoes-	Connects to the specific mysql server, and opened a database.
$dbh=mysql_connect("localhost", "sangla_mailu", "jjj5534") or 
	die ('I cannot connect to the database because: ' . mysql_error());
         mysql_select_db ("sangla_gene",$dbh);
?>
