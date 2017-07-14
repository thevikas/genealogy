<?php
class TreeAction extends CAction
{
    private $root_id;
    public function run($id)
    {
        Yii::app ()->clientScript->registerCoreScript ( 'tree' );
        $this->controller->pageTitle = __ ( 'Family Tree' );
        $this->root_id = $id;
        $this->controller->layout = '//layouts/fullwidth';
        $this->controller->render('tree',['person' => Person::model()->findByPk($id)]);
    }

    function showMarriages(Person $person, $level, $isDead, $bpic, $opt = '')
    {
        global $high;
        $married = false;
        ?>
        <div class="dtable">
        	<table border="0" class="level<?=$level?>"><?
        // 20060708
        // 1) first list the wife and husband
        
        // $sql = "select w.name as `wife`,h.name as `husband`,m.*,h.treepos as
        // htp,w.treepos as wtp, w.dob as `w_dob`, h.dob as `h_dob`, w.isDead as
        // `w_dead`, h.isDead as `h_dead`,w.father_cid as
        // `w_father`,h.father_cid as `h_father`,ws.father_root as
        // `w_father_root`,hs.father_root as `h_father_root` from marriages
        // m,persons h,persons w,stats hs,stats ws where hs.cid = h.cid and
        // ws.cid=w.cid and w.cid=wife_cid and h.cid=husband_cid and $cid in
        // (husband_cid,wife_cid) order by w.name";
        // $sql = "select w.name as `wife`,h.name as `husband`,m.*,h.treepos as
        // `htp`,w.treepos as `wtp`, w.dob as `w_dob`, h.dob as `h_dob`,
        // w.isDead as `w_dead`, h.isDead as `h_dead`,h.father_root as
        // `h_root`,w.father_root as `w_root`,h.father_cid as
        // `h_father_cid`,h.bPics as `h_pic`,w.bPics as `w_pic` from marriages
        // m,persons h,persons w where w.cid=wife_cid and h.cid=husband_cid and
        // $cid in (husband_cid,wife_cid) order by w.name";
        // $r1 = doquery($sql);
        
        foreach ( $person->spouses as $spouse )
        {
            $married = true;
            /*if (intval ( $cid ) == intval ( $high ))
            {
                // echo " style=\"font-weight:bold;\" ";
            }*/
            ?>
		<tr>
			<td valign="top">
		<?
            
		if ($person->cid == $this->root_id && $person->father_cid > 0)
            {
                global $wx;
                ?>
			<a href="?cid=<?=$person->father_cid?>&wx=<?=$wx?>#p<?=$person->cid?>">Up</a>
			<?
            }
            
            //201707091400:vikas:Gurgaon
            //dont know what is the pointof the  IF construct here
            //if ($cid == $rs1->husband_cid)
            //{
                ?><div class="left_spouse"><?                
                echo $spouse->treepos;                
                echo $spouse->getnamelink(['flip' => 1]);
                ?></div><?
            //}
            /*else
            {
                ?><div class="left_spouse"><?
                echo $rs1->wtp;
                $this->showPersonLink2 ( $person, $rs1->w_dead, 0, $rs1->w_pic );
                $age = getYearsCount ( $rs1->w_dob, time () );
                if ($age != "")
                    echo " ($age)";
                ?> + <?
                $this->showPersonLink2 ( $rs1->husband_cid, $rs1->h_dead, $rs1->h_root, $rs1->w_pic );
                $age = getYearsCount ( $rs1->h_dob, time () );
                if ($age != "")
                    echo " ($age)";
                ?></div><?
            }*/
            // 2) list all thier children in the foloowing tabe
            
                $father = $spouse;
                $mother = $person;
                if($person->gender)
                {
                    $father = $person;
                    $mother = $spouse;
                }
                $this->showChildren ( $father, $mother,$level );
            ?>
			<!-- after childred -->
			</td>
		<?
            
if (isset ( $opt ['bLastChild'] ))
            {
                // WARNING: IF YOU CHANGE BELOW, CHANGE THE UNMARRIED BLOCK TOO
                ?>
			<td><a href="javascript:void(0)"
				onclick="addchild(this,<?=$opt['fcid'] . "," . $opt['mcid'] ?>)">+</a>
			</td>
		<? } ?>
		</tr>
		<?
        }
        if ($married == false)
        {
            ?><tr>
			<td valign="top"><?
            echo $person->namelink;
            ?>
		&nbsp;<a href="#"
				onclick="addspouse(this,<?=$person->gender?>,<?=$person->cid?>)">*</a></td>

		<?
            
if (isset ( $opt ['bLastChild'] ))
            {
                // WARNING: IF YOU CHANGE BELOW, CHANGE THE MARRIED BLOCK TOO
                ?>
			<td><a href="javascript:void(0)"
				onclick="addchild(this,<?=$opt['fcid'] . "," . $opt['mcid'] ?>)">+</a>
			</td>
		<? } ?>
		</tr><?
        }
        ?>
	</table>
</div>
<?
    }

    function showChildren(Person $father, Person $mother, $level)
    {
        $child_count = 0;
        //$r1 = doquery ( "select * from persons where father_cid=$fcid and mother_cid=$mcid order by treepos" );
        $children = Person::model()->findAllByAttributes(['father_cid' => $father->cid,'mother_cid' => $mother->cid]);
        $children_count = count($children);
        $opt = array (
                'fcid' => $father->cid,
                'mcid' => $mother->cid 
        );
        foreach ( $children as $child )
        {
            $child_count ++;
            $opt ['bLastChild'] = $children_count == $child_count;
            $this->showMarriages ( $child, $level + 1, $child->isDead, $child->bPics, $opt );
        }
    }
    
    function showPersonLink2(Person $person, $dead, $hroot, $pic)
    {
        global $counter;
        $counter ++;
        echo $img = CHtml::image( "/imgs/" . ($dead ? "dead_" : "") . ($gender==1 ? "man" : "woman") . "_icon.gif",['height' => 15]);
        echo $person->getnamelink(['nospouse' => 1]);
        
        // if father_root is different from father_cid then show the pointer
        if ($pic > 0)
        {
            ?><sup>p</sup><?php
        }
        if ($hroot > 0)
        {
            echo CHtml::tag('sup',CHtml::link('(!)',['person/tree','id' => $hroot,'#' => $person->cid]));            
        }
    }

    function showFamily(Person $person)
    {
        $this->showMarriages ( $person, 1, false, 0 );
    }
    /*
     * $wx = isset ( $_GET ["wx"] ) ? $_GET ["wx"] : 0;
     * if ($wx > 0)
     * {
     * ?>
     * <style type="text/css">
     * div#box {
     * width: <?=$wx?>px;
     * }
     * </style>
     * <?
     * }
     * ?>
     * wx=<?=$wx?>;
     * <a href="?cid=<?=$cid?>&wx=1500">1500px</a>
     * <a href="?cid=<?=$cid?>&wx=2000">2000px</a>
     * <a href="?cid=<?=$cid?>&wx=3000">3000px</a>
     * <a href="?cid=<?=$cid?>&wx=4000">4000px</a>
     * <input type="text" id="writehere" />
     * <div id="box">
     * <?
     * echo "<dir>";
     * $counter = 0;
     * showFamily ( $cid );
     * echo "</dir>";
     * ?>
     * <h3><?=$counter?></h3>
     * </div>
     */
}


