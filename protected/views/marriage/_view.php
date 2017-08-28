<?php
/* @var $this MarriageController */
/* @var $data Marriage */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->mid), array('view', 'id'=>$data->mid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('husband_cid')); ?>:</b>
	<?php echo CHtml::encode($data->husband_cid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wife_cid')); ?>:</b>
	<?php echo CHtml::encode($data->wife_cid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dated')); ?>:</b>
	<?php echo CHtml::encode($data->dated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comments')); ?>:</b>
	<?php echo CHtml::encode($data->comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dom')); ?>:</b>
	<?php echo CHtml::encode($data->dom); ?>
	<br />


</div>