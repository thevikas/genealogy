<p><?php
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

echo CHtml::textField ( 'person_search', '', 
        array (
                'placeholder' => __ ( 'Search' ),
                'class' => 'person_quick' 
        ) );

$this->endWidget ();
?>
</p> 