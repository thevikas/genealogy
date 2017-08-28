<?php
/* @var $this PersonController */
/* @var $model Person */
/* @var $spouse Person */
/* @var $form CActiveForm */
?>

<div class="form wide">

<?php

$form = $this->beginWidget ( 'CActiveForm', 
        array (
                'id' => 'person-form',
                // Please note: When you enable ajax validation, make sure the
                // corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in
                // generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false 
        ) );
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php

echo $form->errorSummary ( $model );
?>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'firstname' );
?>
		<?php

echo $form->textField ( $model, 'firstname', array (
        'size' => 60,
        'maxlength' => 255 
) );
?>
		<?php

echo $form->error ( $model, 'firstname' );
?>
	</div>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'lastname' );
?>
		<?php

echo $form->textField ( $model, 'lastname', array (
        'size' => 60,
        'maxlength' => 255 
) );
?>
		<?php

echo $form->error ( $model, 'lastname' );
?>
	</div>
	
	<div class="row">
		<?php

echo $form->labelEx ( $model, 'father_cid' );
?>
		<?php

echo $form->hiddenField ( $model, 'father_cid' );
?>
		<?php

echo CHtml::textField ( 'father_quick', $model->father_cid ? $model->father->name : '', 
        array (
                'placeholder' => $model->getAttributeLabel ( 'father_cid' ),
                'class' => 'person_quick',
                'size' => 50,
                'target' => 'Person_father_cid' 
        ) );
?>
		<br />
		<?php

echo $form->error ( $model, 'father_cid' );
?>
	</div>
	<style type="text/css">
	#Person_gender br
	{
	display:none;
	}
	#Person_gender label
	{
	float:none;
	display:inline;
	}
	</style>
	<div class="row">
		<?php

echo $form->labelEx ( $model, 'mother_cid' );
?>
		<?php

echo $form->hiddenField ( $model, 'mother_cid' );
?>
		<?php

echo CHtml::textField ( 'mother_quick', $model->mother_cid ? $model->mother->name : '', 
        array (
                'placeholder' => $model->getAttributeLabel ( 'mother_cid' ),
                'class' => 'person_quick',
                'size' => 50,
                'target' => 'Person_mother_cid        ' 
        ) );
?>
		<br />
		<?php

echo $form->error ( $model, 'mother_cid' );
?>
	</div>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'gender' );
echo $form->radioButtonList ( $model, 'gender', [ 
        1 => __ ( 'Male' ),
        0 => __ ( 'Female' ) 
] );
echo $form->error ( $model, 'gender' );
?>
	</div>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'dob' );
?>
		<?php

echo $form->textField ( $model, 'dob' );
?>
		<?php

echo $form->error ( $model, 'dob' );
?>
	</div>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'dod' );
?>
		<?php

echo $form->textField ( $model, 'dod' );
?>
		<?php

echo $form->error ( $model, 'dod' );
?>
	</div>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'address' );
?>
		<?php

echo $form->textField ( $model, 'address', array (
        'size' => 60,
        'maxlength' => 250 
) );
?>
		<?php

echo $form->error ( $model, 'address' );
?>
	</div>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'phone_mobile' );
?>
		<?php

echo $form->textField ( $model, 'phone_mobile', array (
        'size' => 20,
        'maxlength' => 20 
) );
?>
		<?php

echo $form->error ( $model, 'phone_mobile' );
?>
	</div>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'phone_res' );
?>
		<?php

echo $form->textField ( $model, 'phone_res', array (
        'size' => 20,
        'maxlength' => 20 
) );
?>
		<?php

echo $form->error ( $model, 'phone_res' );
?>
	</div>

	<div class="row">
		<?php

echo $form->labelEx ( $model, 'phone_off' );
?>
		<?php

echo $form->textField ( $model, 'phone_off', array (
        'size' => 20,
        'maxlength' => 20 
) );
?>
		<?php

echo $form->error ( $model, 'phone_off' );
?>
	</div>

	<div class="row buttons">
		<?php

echo CHtml::submitButton ( $model->isNewRecord ? 'Create' : 'Save' );
?>
	</div>

<?php
if (! empty ( $spouse ))
    echo CHtml::hiddenField ( 'spouse_id', $spouse->cid );
$this->endWidget ();
?>

</div><!-- form -->