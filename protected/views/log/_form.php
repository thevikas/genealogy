<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'uid'); ?>
		<?php echo $form->textField($model,'uid'); ?>
		<?php echo $form->error($model,'uid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ltype'); ?>
		<?php echo $form->textField($model,'ltype'); ?>
		<?php echo $form->error($model,'ltype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dated'); ?>
		<?php echo $form->textField($model,'dated'); ?>
		<?php echo $form->error($model,'dated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'param'); ?>
		<?php echo $form->textField($model,'param',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'param'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->