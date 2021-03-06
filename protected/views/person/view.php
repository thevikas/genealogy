<?php
/* @var $this PersonController */
/* @var $model Person */
$this->breadcrumbs = array (
        'People' => array (
                'index'
        )
);
#20170803:vikas:ggn:fixed error in breadcrumb link vs text
if ($model->grandfather)
    $this->breadcrumbs [$model->grandfather->name] = [
            '/person/view',
            'id' => $model->grandfather->cid
    ];

if ($model->father)
    $this->breadcrumbs [$model->father->name] = [
            '/person/view',
            'id' => $model->father->cid
    ];

$this->breadcrumbs [] = $model->name;

$this->menu = array (
        array (
                'label' => __ ( 'List Person' ),
                'url' => array (
                        'index'
                )
        ),
        array (
                'encodeLabel' => false,
                'label' => '<i class="fa fa-plus"></i> ' . __ ( 'Create Person' ),
                'url' => array (
                        'create'
                )
        ),
        array (
                'encodeLabel' => false,
                'label' => '<i class="fa fa-edit"></i> ' .__ ( 'Update Person' ),
                'url' => array (
                        'update',
                        'id' => $model->cid
                )
        ),
        array (
                'label' => __ ( 'Create Parent' ),
                'url' => array (
                        'create',
                        'child_id' => $model->cid
                )
        ),
        array (
                'label' => __ ( 'Create Spouse' ),
                'url' => array (
                        'create',
                        'spouse_id' => $model->cid
                )
        ),
        array (
                'label' => __ ( 'Add Spouse' ),
                'url' => array (
                        'marriage/create',
                        'spouse_id' => $model->cid,
                        'sg' => $model->gender
                )
        ),
        array (
                'label' => __ ( 'Distance Report' ),
                'url' => array (
                        'distance',
                        'root_id' => $model->cid
                )
        ),
        array (
                'label' => __ ( 'Tree Report' ),
                'url' => array (
                        'person/tree',
                        'id' => $model->cid
                )
        ),
        array (
                'label' => __ ( 'Circle Chart' ),
                'url' => array (
                        'person/circlechart',
                        'id' => $model->cid
                )
        ),
        array (
                'label' => __ ( 'D3 Chart Dendogram' ),
                'url' => array (
                        'chart/d3',
                        'id' => $model->cid,
                        "c" => 0
                )
        ),
        array (
                'label' => __ ( 'D3 Chart Radial' ),
                'url' => array (
                        'chart/d3',
                        'id' => $model->cid,
                        "c" => 1
                )
        ),
        array (
                'label' => __ ( 'D3 Chart Drag &amp; Drop' ),
                'url' => array (
                        'chart/d3',
                        'id' => $model->cid,
                        "c" => 2
                )
        ),
        array (
                'label' => __ ( 'D3 Wheel' ),
                'url' => array (
                        'chart/d3',
                        'id' => $model->cid,
                        "c" => 3
                )
        ),
        array (
                'label' => '<i class="fa fa-trash-o"></i> ' . __ ( 'Delete Person' ),
                'encodeLabel' => false,
                'url' => '#',
                'linkOptions' => array (
                        'submit' => array (
                                'delete',
                                'id' => $model->cid
                        ),
                        'confirm' => 'Are you sure you want to delete this item?'
                )
        ),
        array (
                'label' => __ ( 'Manage Person' ),
                'url' => array (
                        'admin'
                )
        )
);
?>

<h1><?php

echo $model->getnamelink ( [
        'nospouse' => 1,
        'nolink'
] );
?></h1>

<?php

echo $this->renderPartial ( '_view', [
        'data' => $model,
        'detailed' => true
] );
?>
<?php

echo $this->renderPartial ( '_grandchildren', [
        'data' => $model,
        'detailed' => true
] );
?>
<?php

echo $this->renderPartial ( '_greatgrandchildren', [
        'data' => $model,
        'detailed' => true
] );
?>
