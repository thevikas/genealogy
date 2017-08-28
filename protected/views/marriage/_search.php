<?php
/* @var $this MarriageController */
/* @var $model Marriage */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'husband_cid'); ?>
		<?php echo $form->textField($model,'husband_cid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wife_cid'); ?>
		<?php echo $form->textField($model,'wife_cid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dated'); ?>
		<?php echo $form->textField($model,'dated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mid'); ?>
		<?php echo $form->textField($model,'mid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comments'); ?>
		<?php echo $form->textField($model,'comments',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dom'); ?>
		<?php echo $form->textField($model,'dom'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->