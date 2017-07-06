<?php
/* @var $this MarriageController */
/* @var $model Marriage */

$this->breadcrumbs=array(
	'Marriages'=>array('index'),
	$model->mid=>array('view','id'=>$model->mid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Marriage', 'url'=>array('index')),
	array('label'=>'Create Marriage', 'url'=>array('create')),
	array('label'=>'View Marriage', 'url'=>array('view', 'id'=>$model->mid)),
	array('label'=>'Manage Marriage', 'url'=>array('admin')),
);
?>

<h1>Update Marriage <?php echo $model->mid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>