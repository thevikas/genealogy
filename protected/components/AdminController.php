<?php
/**
 * Created 20121019436:vikas:#160:re combine all layouts for all admins
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends Controller
{
	var $topmenuname = 'adminmenu';
	var $sublayout = false;

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
		);
	}

    /**
     * Inits language defaults depending on session, GET and config defaults
     * This method can overloaded by inheritence.
     * 201604261540:vikas:#454:Gurgaon
     */
	public function initLanguage()
	{
	    if(!empty($_GET['lang']))
	    {
	        Yii::app()->session['lang'] = Yii::app()->language = $_GET['lang'];
	    }
	    elseif(!empty(Yii::app()->session['lang']))
	    {
	        $_GET['lang'] = Yii::app()->language = Yii::app()->session['lang'];
	    }
	    else
	    {
	        Yii::app()->language = 'en';
	    }
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
	                    'actions'=>array('index','view'),
	                    'roles'=>array('admin'),
	            ),
	            array('allow', // allow authenticated user to perform 'create' and 'update' actions
	                    'actions'=>array('create','update'),
	                    'roles'=>array('admin'),
	            ),
	            array('allow', // allow admin user to perform 'admin' and 'delete' actions
	                    'actions'=>array('admin','delete'),
	                    'roles'=>array('admin'),
	            ),
	            array('deny',  // deny all users
	                    'users'=>array('*'),
	            ),
	    );
	}
}