<?php
class clsXY
{
	public $x,$y;
}

global $centerx;
global $centery;

global $master_circle_r;
$master_circle_r = 100;

$centerx = $centery = 1000;

$colors[1] = "green";
$colors[2] = "yellow";
$colors[3] = "orange";
$colors[4] = "blue";
$colors[5] = "purple";
$colors[6] = "brown";
$colors[7] = "pink";
$colors[8] = "gold";
$colors[9] = "white";

global $between_circle_gap;
$between_circle_gap=50;

global $circle_levels;
$circle_levels=0;

global $text_space;
$text_space=10;

global $pathIDMaster;
$pathIDMaster = array();
global $pathCtr;
$pathCtr=0;
global $maxLevel;
$maxLevel=0;

global $maxDepth;

function drawTree($data,$level,$anglenow,$child_index,$past_angles_total)
{
	//print "\ndrawTree($data,$level,$anglenow,$child_index,$past_angles_total) \n================================================================\n";
	global $circle_levels;
	global $text_space;
	
	global $master_circle_r;
	global $centerx;
	global $centery;
	global $colors;

    global $pathIDMaster;
    global $pathCtr;
	
	global $between_circle_gap;
    global $maxDepth;

    global $maxLevel;
    if($level>$maxLevel)
        $maxLevel = $level;

    if($level==1)
    {
        #check depth and shift centerx and centerx so that it comes to the top left corner always.
        #print "depth=" . $data['depth'];
        $centery = $centerx = ($master_circle_r+($between_circle_gap*$data['depth'])) + $between_circle_gap;
        $maxDepth = $data['depth'];
        #die;
    }

    $between_circle_gap_local = $between_circle_gap - ($level*.8);
	
	$circle_r = ($master_circle_r+($between_circle_gap*$level));
	#radious increased by each level
	#every level draws a circle
	if($circle_levels<$level)
	{
		$circle_levels = $level;
		?>
		<circle  fill="none" stroke="<?=$colors[$level]?>" cx="<?=$centerx?>" cy="<?=$centery?>" r="<?=$circle_r?>" />
		<?
	}
	
	#print_r($data['children']);
	if(!is_array($data['children']) || count($data['children'])==0)
		return false;
		
	$parts = count($data['children']);
	$each_angle = $anglenow/$parts;
	$ctr = 0;

	//print "\nChildren: $parts\n";
	
	foreach($data['children'] as $childa)
	{
    
        #200910181555:vikas:L87:decrease stroke width by levels
        $stroke_width = 1 * pow( ( 1 - 0.3) , $level);
        
		
		$asy = $asx = $circle_r + $text_space;
		
		$from = new clsXY();
		
		$groupxy = calculateXY3($past_angles_total + ($ctr*$each_angle) ,$ctr,$each_angle,$asx);
		
		$from->x = $groupxy[0];
		$from->y = $groupxy[1];
		
		$toxy->x = $groupxy[2];
		$toxy->y = $groupxy[3];
		
		$pathID = "path{$pathCtr}";
        $pathCtr++;

		?>
		<path id="<?=$pathID?>" d="M<?=$from->x?>,<?=$from->y?> A<?=$asx?>,<?=$asy?> 0 0,1 <?=$toxy->x?>,<?=$toxy->y?> z"
		stroke="none" fill="none" stroke-width="0"/>
		
		<?

        if(!isset($pathIDMaster[$pathID]))
            $pathIDMaster[$pathID]=1;
        else
            die("oops! $pathID was used altready!");
		
		$groupxy = calculateXY3($past_angles_total + ($ctr*$each_angle) ,$ctr,$each_angle,$circle_r);
		
		$line_start_x = $groupxy[0];
		$line_start_y = $groupxy[1];

		$groupxy = calculateXY3($past_angles_total + ($ctr*$each_angle) ,$ctr,$each_angle,$circle_r + $between_circle_gap);
		
		$line_end_x = $groupxy[0];
		$line_end_y = $groupxy[1];
		
		$pathID = "pathM{$pathCtr}";
        $pathCtr++;

		?>
		<path id="<?=$pathID?>" d="M<?=$line_end_x?>,<?=$line_end_y?>
		L<?=$line_start_x?>,<?=$line_start_y?>  z"
		stroke="green" fill="none" stroke-width="<?=$stroke_width?>"/>

        <text class="txt level<?=$level?>">
			<textPath startOffset="5" spacing="auto" method="stretch" xlink:href="#<?=$pathID?>"><?=$childa['name']?></textPath>
		</text>
        <?

        $gap_to_last_level = (($maxDepth - $level) * $between_circle_gap);
		
		$groupxy = calculateXY3($past_angles_total + ($ctr*$each_angle) ,$ctr,$each_angle,$circle_r + $gap_to_last_level);
		
		$line_end_x = $groupxy[0];
		$line_end_y = $groupxy[1];

        $stroke_width = 1 * pow( ( 1 - 0.3) , $maxDepth);

        ?>
		<path d="M<?=$line_end_x?>,<?=$line_end_y?>
		L<?=$line_start_x?>,<?=$line_start_y?>  z"
		stroke="green" fill="none" stroke-width="<?=$stroke_width?>"/>

		<?
		#draw the child text
		#draw the arc
		#draw the divider
		
		#continue;
		drawTree($childa,$level+1,$each_angle,$ctr,$past_angles_total+$each_angle*$ctr);
		$ctr++;
		
		//if($level==1)
		//	break;
	}
	
	//print "\n<!-- back $level -->\n";
}





function calculateXY($past_angles,$ctr,$each_angle,$radius)
{
	//print "\ncalculateXY($past_angles,$ctr,$each_angle,$radius)\n";
	global $centerx;
	global $centery;

	$fromxy = calculateXY_old($past_angles + $each_angle,$radius);
	$toxy = calculateXY_old($past_angles + $each_angle,$radius);
	
	$arr = array($fromxy,$toxy);
	//print_r($arr);
	return $arr;
}

function calculateXY3($past_angles,$ctr,$each_angle,$radius)
{
	//print "\ncalculateXY($past_angles,$ctr,$each_angle,$radius)\n";
	global $centerx;
	global $centery;

	$hype = $radius;
	
	#P/H = sin(theta)
	$P = sin(deg2rad($past_angles))*$radius;
	$B = cos(deg2rad($past_angles))*$radius;
	
	//print "\nP $P,B $B\n";
	
	$startx = $centerx + $P;
	$starty = $centery - $B;
	
	$past_angles += $each_angle;
	#P/H = sin(theta)
	$P = sin(deg2rad($past_angles))*$radius;
	$B = cos(deg2rad($past_angles))*$radius;
	
	$endx = $centerx + $P;
	$endy = $centery - $B;

	$rt = array($startx,$starty,$endx,$endy);
	//print_r($rt);
	return $rt;
}

function drawLevels($maxlevel,$arr)
{
    global $master_circle_r;
    global $between_circle_gap;
    global $colors;
    global $centerx;
    global $centery;

    for($i=$maxlevel; $i>=1; $i--)
    {
        $between_circle_gap_local = $between_circle_gap - ($i*.8);
	    $circle_r = ($master_circle_r+($between_circle_gap*$i));
	    #radious increased by each level
	    #every level draws a circle
	    ?>
	    <circle stroke="<?=$colors[$i]?>" fill="<?=$colors[$i]?>" cx="<?=$centerx?>" cy="<?=$centery?>" r="<?=$circle_r?>" />
	    <?
        
   }

    $startx = $centerx - (strlen($arr['name'])/2)*8;
   ?>
    <text class="txt root" x="<?=$startx?>" y="<?=$centery?>">
    <?=$arr['name']?>
    </text>
   <?

}