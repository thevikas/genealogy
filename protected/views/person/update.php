<?php
/* @var $this PersonController */
/* @var $model Person */

$this->breadcrumbs=array(
	'People'=>array('index'),
	$model->name=>array('view','id'=>$model->cid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Person', 'url'=>array('index')),
	array('label'=>'Create Person', 'url'=>array('create')),
	array('label'=>'View Person', 'url'=>array('view', 'id'=>$model->cid)),
    array('label'=>__('D3 Wheel'), 'url'=>array('chart/d3', 'id'=>$model->cid,"c" => 3)),
    array('label'=>'Manage Person', 'url'=>array('admin')),
);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>