<?php
/* @var $this PersonController */
/* @var $model Person */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'person-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'father_cid'); ?>
		<?php echo $form->textField($model,'father_cid'); ?>
		<?php echo $form->error($model,'father_cid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mother_cid'); ?>
		<?php echo $form->textField($model,'mother_cid'); ?>
		<?php echo $form->error($model,'mother_cid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dated'); ?>
		<?php echo $form->textField($model,'dated'); ?>
		<?php echo $form->error($model,'dated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model,'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->textField($model,'gender'); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dob'); ?>
		<?php echo $form->textField($model,'dob'); ?>
		<?php echo $form->error($model,'dob'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dod'); ?>
		<?php echo $form->textField($model,'dod'); ?>
		<?php echo $form->error($model,'dod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bPics'); ?>
		<?php echo $form->textField($model,'bPics'); ?>
		<?php echo $form->error($model,'bPics'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'treepos'); ?>
		<?php echo $form->textField($model,'treepos',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'treepos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isDead'); ?>
		<?php echo $form->textField($model,'isDead'); ?>
		<?php echo $form->error($model,'isDead'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone_mobile'); ?>
		<?php echo $form->textField($model,'phone_mobile',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phone_mobile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone_res'); ?>
		<?php echo $form->textField($model,'phone_res',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phone_res'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone_off'); ?>
		<?php echo $form->textField($model,'phone_off',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phone_off'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'father_root'); ?>
		<?php echo $form->textField($model,'father_root',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'father_root'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated'); ?>
		<?php echo $form->textField($model,'updated'); ?>
		<?php echo $form->error($model,'updated'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->