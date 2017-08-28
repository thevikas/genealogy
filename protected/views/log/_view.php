<?php
/* @var $this LogController */
/* @var $data Log */

$oClass = new ReflectionClass('Log');
$con0 = $oClass->getConstants();
$con1 = array_flip($con0);
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

<?php
switch($data->ltype)
{
    case Log::LOG_EDITPERSON	:
        ?>
        <b><?php echo CHtml::encode($data->getAttributeLabel('Person.name')); ?>:</b>
        <?=$data->person->namelink;?>
        <br />
        <?php 
    default:
        { ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('uid')); ?>:</b>
	<?php echo CHtml::encode($data->uid); ?>
	<br />
        <?php 
        }
}
?>
    
	<b><?php echo CHtml::encode($data->getAttributeLabel('ltype')); ?>:</b>
	<?php echo CHtml::encode($con1[$data->ltype]); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dated')); ?>:</b>
	<?php echo CHtml::encode($data->dated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('param')); ?>:</b>
	<?php echo CHtml::encode($data->param); ?>
	<br />


</div>