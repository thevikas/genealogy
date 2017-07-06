<?php
/* @var $this MarriageController */
/* @var $model Marriage */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'marriage-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'husband_cid'); ?>
		<?php echo $form->textField($model,'husband_cid'); ?>
		<?php echo $form->error($model,'husband_cid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wife_cid'); ?>
		<?php echo $form->textField($model,'wife_cid'); ?>
		<?php echo $form->error($model,'wife_cid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dated'); ?>
		<?php echo $form->textField($model,'dated'); ?>
		<?php echo $form->error($model,'dated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comments'); ?>
		<?php echo $form->textField($model,'comments',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dom'); ?>
		<?php echo $form->textField($model,'dom'); ?>
		<?php echo $form->error($model,'dom'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->