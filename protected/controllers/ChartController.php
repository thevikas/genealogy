<?php

class ChartController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function actions()
	{
	    return array(
            );
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'users'=>array('*'),
			),			
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionD3($id,$c,$jsononly=0)
	{
	    $chartname[] = "dendogram";
	    //Yii::app ()->clientScript->registerCoreScript ( 'd3dtree' );
	    $this->pageTitle = __ ( 'D3 Family Circle Chart' );
	    $this->layout = false;//'//layouts/fullwidth';
	    $model = Person::model()->findByPk($id);
	    
	    if($jsononly)
	    {
	        header('Content-Type: application/json');
	        echo json_encode($model->D3hierarchy);
	        return;
	    }
	    
	    $this->render ( $chartname [$c], 
                [ 
                        'person' => $model,
                        'chart_code' => $c,
                        'mother' => CHtml::link ( __ ( 'Mother' ) ,['d3','id' => $model->mother_cid,'c' => $c]),
                        'father' => CHtml::link ( __ ( 'Father' ) ,['d3','id' => $model->father_cid,'c' => $c]),
                ] );	    
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Person the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Person::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
