<?php
/* @var $this PersonController */
/* @var $model Person */

$this->breadcrumbs=array(
	'People'=>array('index'),
	$model->name,
);

$this->menu=array(
        array('label'=>__('List Person'), 'url'=>array('index')),
        array('label'=>__('Create Person'), 'url'=>array('create')),
        array('label'=>__('Update Person'), 'url'=>array('update', 'id'=>$model->cid)),
        array('label'=>__('Create Spouse'), 'url'=>array('create', 'spouse_id'=>$model->cid)),
        array('label'=>__('Add Spouse'), 'url'=>array('marriage/create', 'spouse_id'=>$model->cid,'sg' => $model->gender)),
        array('label'=>__('Tree Report'), 'url'=>array('person/tree', 'id'=>$model->cid)),
        array('label'=>__('Delete Person'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cid),'confirm'=>'Are you sure you want to delete this item?')),
        array('label'=>__('Manage Person'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_view',['data' => $model,'detailed'=>true]); ?>