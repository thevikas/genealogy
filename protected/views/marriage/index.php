<?php
/* @var $this MarriageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Marriages',
);

$this->menu=array(
	array('label'=>'Create Marriage', 'url'=>array('create')),
	array('label'=>'Manage Marriage', 'url'=>array('admin')),
);
?>

<h1>Marriages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
