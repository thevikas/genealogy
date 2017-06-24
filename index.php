<?
include("./common.php");

#import_request_variables("pg","");
$title = "Search Persons";
include("./top.php");
doInit_Dates();

include("./search_form.php");

include("./bottom.php");
?>