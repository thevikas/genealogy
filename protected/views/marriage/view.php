<?php
/* @var $this MarriageController */
/* @var $model Marriage */

$this->breadcrumbs=array(
	'Marriages'=>array('index'),
	$model->mid,
);

$this->menu=array(
	array('label'=>'List Marriage', 'url'=>array('index')),
	array('label'=>'Create Marriage', 'url'=>array('create')),
	array('label'=>'Update Marriage', 'url'=>array('update', 'id'=>$model->mid)),
	array('label'=>'Delete Marriage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->mid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Marriage', 'url'=>array('admin')),
);
?>

<h1>View Marriage #<?php echo $model->mid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        array(               // related city displayed as a link
                'label'=>__('Husband'),
                'type'=>'raw',
                'value'=>$model->husband->namelink,
        ),
        array(               // related city displayed as a link
            'label'=>__('Wife'),
            'type'=>'raw',
            'value'=>$model->wife->namelink,
        ),
		'created',
		'mid',
		'comments',
		'dom',
	),
)); ?>
