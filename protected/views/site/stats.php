<?php
/* @var $this SiteController */
$this->breadcrumbs [] = __('Stats');

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

$data3=[];
function filter1(&$v,$k)
{
    $v = ['name' => $k, 'value' => $v];
}

array_walk($stats,"filter1");
sort($stats);

$dataProvider = new CArrayDataProvider ( $stats, array (
        'id' => 'name',
        'keyField' => 'name',
        'pagination' => array (
                'pageSize' => 200
        )
) );

Yii::app ()->clientScript->registerCoreScript ( 'font-awesome' );

$this->widget ( 'zii.widgets.grid.CGridView',
        [
                'id' => 'person-grid',
                'dataProvider' => $dataProvider,
                // 'filter'=>$model,
                'columns' => [
                    ["name" => "name","header" => __('Name')],["name" => "value","header" =>__('Value')]]
        ]
);
