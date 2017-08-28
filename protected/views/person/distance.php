<?php
/* @var $this SiteController */
$this->breadcrumbs = array (
        'People' => array (
                'index'
        )
);

if ($model->grandfather)
    $this->breadcrumbs [$model->grandfather->name] = [
            '/person/view',
            'id' => $model->father->cid
    ];

if ($model->father)
    $this->breadcrumbs [$model->father->name] = [
            '/person/view',
            'id' => $model->father->cid
    ];

$this->breadcrumbs [$model->name] = [
        '/person/view',
        'id' => $model->cid
];

$this->breadcrumbs [] = __('Distance');

$this->menu = array (
        array (
                'label' => __ ( 'List Person' ),
                'url' => array (
                        'index'
                )
        ),
        array (
                'label' => __ ( 'Create Person' ),
                'url' => array (
                        'create'
                )
        ),
        array (
                'label' => __ ( 'Update Person' ),
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
                'label' => __ ( 'Stat Report' ),
                'url' => array (
                        'site/stats',
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
                'label' => __ ( 'Delete Person' ),
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

$this->pageTitle = __('{name} - Distance Chart',['{name}' => $model->name]);

echo "<h1>Distance Calculator</h1>";

$model_cache = [ ];

function CountDistance($distance_for_id, $start_count, $count_from_id, $model_cache)
{
    $data = [ ];
    if (! $count_from_id)
        return [ ];
    if (empty ( $model_cache [$count_from_id] ))
        $model = Person::model ()->findByPk ( $count_from_id );
    $model_cache [$count_from_id] = $model;
    if (! $model)
        return [ ];
    // count for father
    if ($model->father)
    {
        $data [$model->father->id_person] = $start_count + 1;
        if (empty ( $model_cache [$model->father->id_person] ))
            $model_cache [$model->father->id_person] = $model->father;
    }
    // count for mother
    if ($model->mother)
    {
        $data [$model->mother->id_person] = $start_count + 1;
        if (empty ( $model_cache [$model->mother->id_person] ))
            $model_cache [$model->mother->id_person] = $model->mother;
    }
    // count for spouse
    $spouses = $model->spouses;
    if (count ( $spouses ) > 0)
    {
        foreach ( $spouses as $spouse )
        {
            $data [$spouse->id_person] = $start_count + 1;
            if (empty ( $model_cache [$spouse->id_person] ))
                $model_cache [$spouse->id_person] = $spouse;
        }
    }
    // count all children
    $children = $model->children;
    if (count ( $children ) > 0)
    {
        foreach ( $children as $child )
        {
            $data [$child->id_person] = $start_count + 1;
            if (empty ( $model_cache [$child->id_person] ))
                $model_cache [$child->id_person] = $child;
        }
    }
    return $data;
}

$data = [ ];
echo '<pre>';

$counted_ids = [ ];
$queue_ids = [
        $root_id
];
$level = 1;
$ctr = 0;
while ( $next_id = array_pop ( $queue_ids ) )
{
    // ignore if ID is already scanned
    if (isset ( $counted_ids [$next_id] ))
        continue;

    $counted_ids [$next_id] = 1;

    $starting_level = empty ( $data [$next_id] ) ? 1 : $data [$next_id];
    if ($starting_level > $max_level)
        continue;

    $data0 = CountDistance ( 1, $starting_level, $next_id, $model_cache );
    $data += $data0;
    $queue_ids = array_merge ( $queue_ids, array_keys ( $data ) );
    if ($ctr ++ > $limit)
        break;
}
$data [$root_id] = 1;
asort ( $data );

$data2 = [ ];
foreach ( $data as $id => $v )
{
    if (empty ( $model_cache [$id] ))
        $model = Person::model ()->findByPk ( $id );
    else
        $model = $model_cache [$id];

    // echo $v . "\t" . $model->namelink . " = " . implode ( ',', $model->audit
    // ) . "\n";

    $item ['model'] = $model;
    $item ['id'] = $model->cid;
    $item ['level'] = $v;
    $item ['audit'] = $model->audit;
    $data2 [] = $item;
}
echo '</pre>';

$dataProvider = new CArrayDataProvider ( $data2, array (
        'id' => 'id',
        'pagination' => array (
                'pageSize' => 200
        )
) );

Yii::app ()->clientScript->registerCoreScript ( 'font-awesome' );

$this->widget ( 'zii.widgets.grid.CGridView',
        array (
                'id' => 'person-grid',
                'dataProvider' => $dataProvider,
                // 'filter'=>$model,
                'columns' => [
                        [
                                'name' => __ ( 'Level' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return $data ['level'];
                                }
                        ],
                        [
                                'name' => __ ( 'Name' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    // print_r ( $data ['audit'] );
                                    return $data ['model']->getnamelink (
                                            [
                                                    'nospouse' => 1
                                            ] );
                                }
                        ],
                        [
                                'name' => __ ( 'Age' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return $data ['model']->age > 0 ? $data ['model']->age : '';
                                }
                        ],
                        [
                                'name' => __ ( 'DOB' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return array_search ( 'DOB', $data ['audit'] ) === false ? '<i class="fa fa-check" aria-hidden="true"></i>' : '';
                                }
                        ],
                        [
                                'name' => __ ( 'DOM' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return array_search ( 'DOM', $data ['audit'] ) === false ? '<i class="fa fa-check" aria-hidden="true"></i>' : '';
                                }
                        ],
                        [
                                'name' => __ ( 'Father' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return array_search ( 'Father', $data ['audit'] ) === false ? '<i class="fa fa-check" aria-hidden="true"></i>' : CHtml::link('<i class="fa fa-plus" aria-hidden="true"></i>',['person/create',
                                            'child_id' => $data['id'],'gender' => 1
                                    ]);
                                }
                        ],
                        [
                                'name' => __ ( 'Mother' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return array_search ( 'Mother', $data ['audit'] ) === false ? '<i class="fa fa-check" aria-hidden="true"></i>' : 
                                    CHtml::link('<i class="fa fa-plus" aria-hidden="true"></i>',['person/create',
                                            'child_id' => $data['id'],'gender' => 0
                                    ]);
                                }
                        ],
                        [
                                'name' => __ ( 'Children' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    $pluslink = '';
                                    $father_id = $mother_id = 0;
                                    if(isset($data['model']->spouses[0]))
                                    {
                                        
                                        if($data['model']->gender)
                                        {
                                            $father_id = $data['id'];
                                            $mother_id = $data['model']->spouses[0]->cid;
                                        }
                                        else
                                        {
                                            $father_id = $data['model']->spouses[0]->cid;
                                            $mother_id = $data['id'];                                            
                                        }
                                        $pluslink =  CHtml::link('<i class="fa fa-plus" aria-hidden="true"></i>',['person/create',
                                                'father_id' => $father_id,'mother_id' => $mother_id
                                        ]);
                                    }
                                    return array_search ( 'Children', $data ['audit'] ) === false ? '<i class="fa fa-check" aria-hidden="true"></i>' : $pluslink;
                                }
                        ]
                ]
        ) );
