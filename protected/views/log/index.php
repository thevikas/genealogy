<?php
/* @var $this LogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Logs',
);

$this->menu=array(
	array('label'=>'Create Log', 'url'=>array('create')),
	array('label'=>'Manage Log', 'url'=>array('admin')),
);
?>

<h1>Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
