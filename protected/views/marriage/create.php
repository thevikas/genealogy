<?php
/* @var $this MarriageController */
/* @var $model Marriage */

$this->breadcrumbs=array(
	'Marriages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Marriage', 'url'=>array('index')),
	array('label'=>'Manage Marriage', 'url'=>array('admin')),
);
?>

<h1>Create Marriage</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>