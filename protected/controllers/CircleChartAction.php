<?php
class CircleChartAction extends CAction
{
    private $root_id;
    public function run($id)
    {
        #Yii::app ()->clientScript->registerCoreScript ( 'tree' );
        $this->controller->pageTitle = __ ( 'Family Circle Chart' );
        $this->root_id = $id;
        $this->controller->layout = false;//'//layouts/fullwidth';
        $this->controller->render('circlechart',['person' => Person::model()->findByPk($id)]);
    }
}
    
