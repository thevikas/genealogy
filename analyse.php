<?
include("./common.php");

#import_request_variables("pg","");
$title = "Analyse";
include("./top.php");

if(1==1)
{
	#reset all old stats data
	doquery("truncate table stats");
	#reset all root fathers
	doquery("update persons set father_root=0");
	$rs1 = doquery("select * from persons");
	$root_father=0;
	while($ro1 = mysql_fetch_object($rs1))
	{
		$cid = $ro1->cid;
		if($ro1->father_cid>0)
		{
			#get the father of fahter
			$tc = analyse1($ro1->father_cid,true);
			if($tc>0)
			{
				doquery("insert into stats(cid,father_tree,father_root) values($cid,$tc,$root_father)");
			}
			
			$sql = "update persons set father_root = $root_father where cid=$cid";
			doquery($sql);
			#echo $ro1->name . ": father=" . $tc . " - $root_father<br/>";
		}
	}
}

#200508280731
function analyse1($cid,$firstcall)
{
	global $root_father;
	$tree_count = 0;
	#fine father of father recursively
	$rs1 = mysql_fetch_object(doquery("select father_cid from persons where cid=$cid"));
	if($rs1->father_cid>0)
	{
		$tree_count++;
		$tree_count +=	analyse1($rs1->father_cid,false);
	}
	else
	{
		$root_father = $cid;
	}
	return $tree_count;
}


$sql = 'select p.name as `child_name`,p.cid as `child_cid`,p2.name as `father_name`,p2.cid as `father_cid`,s.father_root,sum(father_tree) as `sum1`,count(*) as `count1` from stats s,persons p,persons p2 where p2.cid=s.father_root and p.cid=s.cid group by father_root order by p.cid desc';
$rs2= doquery($sql);
$ctr=1;
?><table><?
while($ro1 = mysql_fetch_object($rs2))
{
	?>
	<tr>
		<td><?=$ctr++?></td>
		<td><a href="openperson.php?cid=<?=$ro1->child_cid?>"><?=$ro1->child_name?></td>
		<td><a href="tree-report.php?cid=<?=$ro1->father_cid?>&high=<?=$ro1->child_cid?>#cid<?=$ro1->child_cid?>"><?=$ro1->father_name?></td>
		<td><?=$ro1->sum1?></td>
		<td><?=$ro1->count1?></td>
	</tr>
	<?
}
?></table>	