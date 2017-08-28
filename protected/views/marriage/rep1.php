<?php
/* @var $this MarriageController */
/* @var $model MarriageRep1 */
$this->breadcrumbs = array (
        'People' => array (
                'index' 
        ),
        'Manage' 
);

$this->menu = array (
        array (
                'label' => 'List Person',
                'url' => array (
                        'index' 
                ) 
        ),
        array (
                'label' => 'Create Person',
                'url' => array (
                        'create' 
                ) 
        ) 
);

Yii::app ()->clientScript->registerScript ( 'search', 
        "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#person-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
" );
?>

<h1>Manage People</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php

echo CHtml::link ( 'Advanced Search', '#', array (
        'class' => 'search-button' 
) );
?>
<div class="search-form" style="display:none">

</div><!-- search-form -->

<?php

$this->widget ( 'zii.widgets.grid.CGridView', 
        array (
                'id' => 'person-grid',
                'dataProvider' => $model->search (),
                'filter' => $model,
                'columns' => array (
                        array ( // display 'create_time' using an expression
                                'header' => __ ( 'Husband' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return $data->husband->getnamelink ( 
                                            [ 
                                                    'nospouse' => 1 
                                            ] );
                                } 
                        ),
                        
                        array ( // display 'create_time' using an expression
                                'header' => __ ( 'Wife' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return $data->wife->getnamelink ( 
                                            [ 
                                                    'nospouse' => 1 
                                            ] );
                                } 
                        ) 
                ) 
        ) );
?>
