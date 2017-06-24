<?
include("./common.php");
exit;
doquery("truncate marriages");
doquery("delete from persons where cid<>1");
doquery("update persons set father_cid=null, mother_cid=null where cid=1");
#doquery("truncate mru");
header("Location: index.php");
?>