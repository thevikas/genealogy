<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	
	public $mainmenuitems;
	
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public static $dic;	
	
	protected function move_uploaded_file($from, $to) {
	    return move_uploaded_file($from, $to);
	}
	
	function render($view, $data = null, $return = false)
	{
	    $out = parent::render ( $view, $data, true );
	    if (isset ( Yii::app ()->params ['runmode'] ) && Yii::app ()->params ['runmode'] == 'test')
	    {
	        global $render_output;
	        return $render_output = $out;
	    }
	
	    if ($return)
	        return $out;
	        else
	            echo $out;
	}
	
	function gnattdateformat($datekey,$id_project)
	{
	    return CHtml::link(date('d',strtotime($datekey)),['project/day','dk' => $datekey,'id' => $id_project],['title' => $datekey]);
	}

    function rounding($v, $k = 0)
    {
        #201706131119:Lucknow:Removing rounding, causing some problems on demo projects
        return round ( $v, 2 );
        
        if (! empty ( $k ))
        {
            if (empty ( $v [$k] ))
                return '';
            else
            {
                $v = $v [$k];
            }
        }
        if (empty ( $v ))
            return '';
        if (isset ( $_GET ['rounding'] ))
            return round ( $v, $_GET ['rounding'] == 1 ? 0 : 6 );
        return round ( $v, 2 );
    }
	
	function formatmoney($val)
	{
	    return '&#8377; ' . $val;
	}
	
	public function __construct($id=null,$module=null)
	{
	    parent::__construct($id,$module);
	    if(!is_object(self::$dic))
	    {
	        Controller::$dic = new Bucket();
	    }
	
	}
	
	public function init()
	{
	    $this->mainmenuitems= array(
	            array('label'=>'Home', 'url'=>array('/site/index')),
	            array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
	            array('label'=>'Contact', 'url'=>array('/site/contact')),
	            array('label'=>__('Projects'), 'url'=>array('/project/index')),
	            array('label'=>'Gnatt', 'url'=>array('/project/gnatt','id' => 1)),
	            array('label'=>__('Inventories'), 'url'=>array('/inventory/index')),
	            array('label'=>'Task', 'url'=>array('/task/index')),
	            array('label'=>'Task Relation', 'url'=>array('/taskrel/index')),
	            array('label'=>'Unit', 'url'=>array('/unit/index')),
	            array('label'=>'Worker', 'url'=>array('/worker/index')),
	            array('label'=>'Material', 'url'=>array('/material/index')),
	            array('label'=>'Person', 'url'=>array('/aperson/index')),
	            array('label'=>'Company', 'url'=>array('/acompany/index')),
	            array('label'=>'Sector', 'url'=>array('/asector/index')),
	            array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
	            array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
	    );
	}
	
}

function getColor($num,$seed = '0.67763600 1478162490') {
    $hash = md5($seed . $num); // modify 'color' to get a different palette
    return array(
            substr($hash, 0, 2), // r
            substr($hash, 2, 2), // g
            substr($hash, 4, 2),
            dechex(255-hexdec(substr($hash, 0, 2))), // r
            dechex(255-substr($hash, 2, 2)), // g
            dechex(255-substr($hash, 4, 2)),
            /*dechex(255-hexdec(substr($hash, 0, 2))), // r
            dechex(255-hexdec(substr($hash, 2, 2))), // g
            dechex(255-hexdec(substr($hash, 4, 2))),*/
    ); //b
}

function changenumbers(&$item,$key)
{
    if(preg_match('/^id/', $key))
        $item = intval($item);
}