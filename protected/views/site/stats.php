<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$stats['total_people'] = Person::model()->count();
$stats['total_people_with_dob'] = Person::model()->count('dob > :dob',[':dob' => '1700-01-01']);
$stats['total_people_with_dob_pc'] = 100*$stats['total_people_with_dob']/$stats['total_people'];

$stats['total_marriages'] = Marriage::model()->count();
$stats['total_people_with_dom'] = Marriage::model()->count('dom > :dom',[':dom' => '1700-01-01']);
$stats['total_people_with_dom_pc'] = 100*$stats['total_people_with_dom']/$stats['total_marriages'];

$stats['total_females'] = Person::model()->count('gender=0');
$stats['total_females_pc'] = 100*$stats['total_females']/$stats['total_people'];

$stats['total_people_born_last_year'] = Person::model()->count('dob >= :dob',[':dob' => date('Y-m-d',strtotime('-1 year'))]);
$stats['total_people_born_last_5years'] = Person::model()->count('dob >= :dob',[':dob' => date('Y-m-d',strtotime('-5 year'))]);
$stats['total_people_born_last_year_pc'] = 100*$stats['total_people_born_last_year']/$stats['total_people'];

$stats['total_dead'] = Person::model()->count('dod > :dod',['dod' => '1700-1-1']);
$stats['total_dead_pc'] = 100*$stats['total_dead']/$stats['total_people'];

$stats['total_dead_females'] = Person::model()->count('gender=0 and dod > :dod',['dod' => '1700-1-1']);
$stats['total_dead_males'] = $stats['total_dead'] - $stats['total_dead_females'];

$stats['total_dead_females_pc'] = 100*$stats['total_dead_females']/$stats['total_females'];
$stats['total_dead_males_pc'] = 100*$stats['total_dead_males']/($stats['total_people'] - $stats['total_females']);

$stats['total_females_pc'] = 100*$stats['total_females']/$stats['total_people'];

echo '<pre>';
print_r($stats);
echo '</pre>';