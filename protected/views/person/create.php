<?php
/* @var $this PersonController */
/* @var $model Person */
/* @var $spouse Person */

$this->breadcrumbs=array(
	'People'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Person', 'url'=>array('index')),
	array('label'=>'Manage Person', 'url'=>array('admin')),
);
?>

<h1><?php
if(spouse)
    echo __('Create Spouse of {name}',['{name}' => $spouse->namelink]);
else
    echo __('Create Person');
?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'spouse' => $spouse)); ?>