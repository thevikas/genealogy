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
	public function actionD3($id,$c,$jsononly=0,$sw = 1300,$sh=3500,$tx=90,$ty=0)
	{
	    $chartname[] = "dendogram";
	    $chartname[] = "radial";
	    $chartname[] = "dndtree";
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
	    
	    $sizes = ['width' => $sw,'height' => $sh,'translate_x' => $tx,'translate_y' => $ty];
	    
	    $this->render ( $chartname [$c], 
                [ 
                        'person' => $model,
                        'chart_code' => $c,
                        'jsonurl' => '/chart/d3/' . $id  . '?c=' . $c . '&jsononly=1',
                        'sizes' => $sizes,
                        'mother' => CHtml::link ( __ ( 'Mother' ) ,['d3','id' => $model->mother_cid,'c' => $c]),
                        'father' => CHtml::link ( __ ( 'Father' ) ,['d3','id' => $model->father_cid,'c' => $c]),
                ] );	    
	}
	
	public function actionDownload()
	{
	    $output_format = $_POST['output_format'];
	    $data = $_POST['data'];
	    
	    if ($output_format == "svg") 
	    {
	        ## If both input & output are SVG, simply return the submitted SVG
	        ## data to the user.
	        ## The only reason to use a server side script is to be able to offer
	        ## the user a friendly way to "download" a file as an attachment.
	        header('Content-Type: image/svg+xml');
	        header('Content-Disposition: attachment; filename="downloaded.svg"');
	        echo $data;	        
	    }
	    ## PDF/PNG output
	    else if ($output_format == "pdf" || $output_format == "png") {
	        $input_file = tempnam(sys_get_temp_dir(), "name1" . microtime(true));
	        $output_file = tempnam(sys_get_temp_dir(), "name2" . microtime(true));
	        
	        file_put_contents($name1, $data);
	        
	        $zoom = ($output_format == "png") ? 10 : 1;
	        
	        # Run "rsvg-convert", create the PNG/PDF file.
	        system("rsvg-convert -o '$output_file' -z '$zoom' -f '$output_format' '$input_file'");
	        
	        # Read the binary output (PDF/PNG) file.
	        $pdf_data = file_get_contents($output_file);
	        
	        ## All is fine, send the data back to the user
	        $mime_type = ($output_format == "pdf")?"application/x-pdf":"image/png";
	        
	        header('Content-Type: ' . $mime_type);
	        header('Content-Disposition: attachment; filename="downloaded.' . $output_format . '"');
	        
	        echo $pdf_data;
	        
	    }
	    
	    
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
