<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app ()->name;

$stats ['total_people'] = Person::model ()->count ();
$stats ['total_people_with_dob'] = Person::model ()->count ( 'dob > :dob', [
        ':dob' => '1700-01-01'
] );
$stats ['total_people_with_dob_pc'] = 100 * $stats ['total_people_with_dob'] / $stats ['total_people'];

$stats ['total_marriages'] = Marriage::model ()->count ();
$stats ['total_people_with_dom'] = Marriage::model ()->count ( 'dom > :dom', [
        ':dom' => '1700-01-01'
] );
$stats ['total_people_with_dom_pc'] = 100 * $stats ['total_people_with_dom'] / $stats ['total_marriages'];

$stats ['total_females'] = Person::model ()->count ( 'gender=0' );
$stats ['total_females_pc'] = 100 * $stats ['total_females'] / $stats ['total_people'];

$stats ['total_people_born_last_year'] = Person::model ()->count ( 'dob >= :dob',
        [
                ':dob' => date ( 'Y-m-d', strtotime ( '-1 year' ) )
        ] );
$stats ['total_people_born_last_5years'] = Person::model ()->count ( 'dob >= :dob',
        [
                ':dob' => date ( 'Y-m-d', strtotime ( '-5 year' ) )
        ] );
$stats ['total_people_born_last_year_pc'] = 100 * $stats ['total_people_born_last_year'] / $stats ['total_people'];

$stats ['total_dead'] = Person::model ()->count ( 'dod > :dod', [
        'dod' => '1700-1-1'
] );
$stats ['total_dead_pc'] = 100 * $stats ['total_dead'] / $stats ['total_people'];

$stats ['total_dead_females'] = Person::model ()->count ( 'gender=0 and dod > :dod', [
        'dod' => '1700-1-1'
] );
$stats ['total_dead_males'] = $stats ['total_dead'] - $stats ['total_dead_females'];

$stats ['total_dead_females_pc'] = 100 * $stats ['total_dead_females'] / $stats ['total_females'];
$stats ['total_dead_males_pc'] = 100 * $stats ['total_dead_males'] / ($stats ['total_people'] - $stats ['total_females']);

$stats ['total_females_pc'] = 100 * $stats ['total_females'] / $stats ['total_people'];

$stats ['total_females_2000'] = Person::model ()->count ( 'gender=0 and dob > :dob',
        [
                ':dob' => '2000-01-01'
        ] );
$stats ['total_males_2000'] = Person::model ()->count ( 'gender=1 and dob > :dob',
        [
                ':dob' => '2000-01-01'
        ] );
$stats ['total_people_2000'] = $stats ['total_males_2000'] + $stats ['total_females_2000'];
$stats ['total_males_2000_pc'] = 100 * $stats ['total_females_2000'] / $stats ['total_people_2000'];
$stats ['total_females_2000_pc'] = 100 - $stats ['total_males_2000_pc'];

$stats ['femals_per_1K_males_2000'] = 1000 * $stats ['total_females_2000_pc'] * 2 / 100;

// ##

$stats ['total_females_p2000'] = Person::model ()->count ( 'gender=0 and dob between :dob1 and :dob2',
        [
                ':dob1' => '1700-01-01',
                ':dob2' => '2000-01-01'
        ] );
$stats ['total_males_p2000'] = Person::model ()->count ( 'gender=1 and dob between :dob1 and :dob2',
        [
                ':dob1' => '1700-01-01',
                ':dob2' => '2000-01-01'
        ] );
$stats ['total_people_p2000'] = $stats ['total_males_p2000'] + $stats ['total_females_p2000'];
$stats ['total_males_p2000_pc'] = 100 * $stats ['total_females_p2000'] / $stats ['total_people_p2000'];
$stats ['total_females_p2000_pc'] = 100 - $stats ['total_males_p2000_pc'];

$stats ['femals_per_1K_males_p2000'] = 1000 * $stats ['total_females_p2000_pc'] * 2 / 100;

Yii::app()->db->createCommand("SET sql_mode = ''")->execute();
$parent_field = 'father_cid';
$q1 = function($parent_field,$subsort = '') { return  "
select avg(avg_age) from (
select parent.cid as pcid,child1.cid as ccid,parent.dob as pdob,child1.dob as cdob,
datediff(child1.dob,parent.dob)/365 as `avg_age`,count(child1.dob) as ctr
from persons parent
	join persons child1 on child1.$parent_field=parent.cid and child1.cid=(select cid from persons cc where cc.$parent_field=parent.cid order by cc.dob $subsort limit 0,1)
where parent.dob>'1700-1-1' and child1.dob>'1700-1-1'
group by parent.cid
order by child1.dob) q1"; };

$father_data = Yii::app()->db->createCommand($q1('father_cid'))->queryScalar();
$mother_data = Yii::app()->db->createCommand($q1('mother_cid'))->queryScalar();

$stats ['age_of_1st_child_fathers'] = $father_data;
$stats ['age_of_1st_child_mothers'] = $mother_data;

$father_data = Yii::app()->db->createCommand($q1('father_cid','desc'))->queryScalar();
$mother_data = Yii::app()->db->createCommand($q1('mother_cid','desc'))->queryScalar();

$stats ['age_of_last_child_fathers'] = $father_data;
$stats ['age_of_last_child_mothers'] = $mother_data;
//$stats ['age_of_first_mothers'] = ;

echo '<pre>';
print_r ( $stats );
echo '</pre>';


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
                                    return array_search ( 'Father', $data ['audit'] ) === false ? '<i class="fa fa-check" aria-hidden="true"></i>' : '';
                                }
                        ],
                        [
                                'name' => __ ( 'Mother' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return array_search ( 'Mother', $data ['audit'] ) === false ? '<i class="fa fa-check" aria-hidden="true"></i>' : '';
                                }
                        ],
                        [
                                'name' => __ ( 'Children' ),
                                'type' => 'raw',
                                'value' => function ($data)
                                {
                                    return array_search ( 'Children', $data ['audit'] ) === false ? '<i class="fa fa-check" aria-hidden="true"></i>' : '';
                                }
                        ]
                ]
        ) );
