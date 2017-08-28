<?php
class MarriageController extends Controller
{
    /**
     *
     * @var string the default layout for the views. Defaults to
     *      '//layouts/column2', meaning
     *      using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     *
     * @return array action filters
     */
    public function filters()
    {
        return array (
                'accessControl', // perform access control for CRUD operations
                'postOnly + delete'  // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     *
     * @return array access control rules
     */
    public function accessRules()
    {
        return array (
                array (
                        'allow', // allow all users to perform 'index' and
                                 // 'view' actions
                        'actions' => array (
                                'index',
                                'view',
                                'stats',
                        ),
                        'users' => array (
                                '*'
                        )
                ),
                array (
                        'allow', // allow authenticated user to perform
                                 // 'create' and 'update' actions
                        'actions' => array (
                                'create',
                                'update',
                                'rep1'
                        ),
                        'users' => array (
                                '@'
                        )
                ),
                array (
                        'allow', // allow admin user to perform 'admin'
                                 // and 'delete' actions
                        'actions' => array (
                                'admin',
                                'delete'
                        ),
                        'users' => array (
                                'admin'
                        )
                ),
                array (
                        'deny', // deny all users
                        'users' => array (
                                '*'
                        )
                )
        );
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id
     *            the ID of the model to be displayed
     */
    public function actionStats()
    {
        $mm = Marriage::model()->findAll([
            'condition' => 't.dom > :dom and (husband.dob > :hdob or wife.dob>:wdob)',
            'with' => ['husband','wife'],
            'together' => true,
            'params' => ['hdob' => '1700-01-01','wdob' => '1700-01-01','dom' => '1700-1-1'],
        ]);

        $data = [];
        foreach($mm as $m)
        {
            $r = [
                'id' => $m->mid,
                'marriage' => $m,
                'husband' => $m->husband,
                'wife' => $m->wife,
                'mage' => $m->age,
                'hname' => $m->husband->name,
                'wname' => $m->wife->name,
                'dom' => $m->dom,
            ];
            if($m->husband->age)
            {
                $r['hage'] = $m->husband->age;
                $r['hmage'] = $m->husband->age - $m->age;
            }

            if($m->wife->age)
            {
                $r['wage'] = $m->wife->age;
                $r['wmage'] = $m->wife->age - $m->age;
            }

            $data[] = $r;
        }



        $dataProvider = new CArrayDataProvider ( $data, array (
                //'id' => 'id',
                'keyField' => 'id',
                'sort'=>array(
                    'attributes'=>array(
                         'mage','wage','hage','hmage','wmage','hname','wname','dom'
                    ),
                ),
                'pagination' => array (
                        'pageSize' => 200
                )
        ) );

        $this->render('stats',['dp' => $dataProvider]);
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id
     *            the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel ( $id );
        $this->pageTitle = __ ( '{hub} & {wife} Marriage',
                [
                        '{hub}' => $model->husband->name,
                        '{wife}' => $model->wife->name
                ] );
        $this->render ( 'view', array (
                'model' => $model
        ) );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view'
     * page.
     */
    public function actionCreate($spouse_id = 0, $sg = 0)
    {
        $model = new Marriage ();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset ( $_POST ['Marriage'] ))
        {
            $model->attributes = $_POST ['Marriage'];
            if ($model->save ())
                $this->redirect (
                        array (
                                'view',
                                'id' => $model->mid
                        ) );
        }
        else if ($spouse_id)
        {
            if ($sg)
                $model->husband_cid = $spouse_id;
            else
                $model->wife_cid = $spouse_id;
        }
        $this->render ( 'create', array (
                'model' => $model
        ) );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view'
     * page.
     *
     * @param integer $id
     *            the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel ( $id );

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset ( $_POST ['Marriage'] ))
        {
            $model->attributes = $_POST ['Marriage'];
            if ($model->save ())
                $this->redirect (
                        array (
                                'view',
                                'id' => $model->mid
                        ) );
        }

        $this->render ( 'update', array (
                'model' => $model
        ) );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin'
     * page.
     *
     * @param integer $id
     *            the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel ( $id )->delete ();

        // if AJAX request (triggered by deletion via admin grid view), we
        // should not redirect the browser
        if (! isset ( $_GET ['ajax'] ))
            $this->redirect (
                    isset ( $_POST ['returnUrl'] ) ? $_POST ['returnUrl'] : array (
                            'admin'
                    ) );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider ( 'Marriage' );
        $this->render ( 'index', array (
                'dataProvider' => $dataProvider
        ) );
    }

    public function actionRep1()
    {
        $model = new MarriageReport1 ( 'search' );
        $model->unsetAttributes (); // clear any default values

        $this->render ( 'rep1', array (
                'model' => $model
        ) );
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Marriage ( 'search' );
        $model->unsetAttributes (); // clear any default values
        if (isset ( $_GET ['Marriage'] ))
            $model->attributes = $_GET ['Marriage'];

        $this->render ( 'admin', array (
                'model' => $model
        ) );
    }

    /**
     * Returns the data model based on the primary key given in the GET
     * variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id
     *            the ID of the model to be loaded
     * @return Marriage the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Marriage::model ()->findByPk ( $id );
        if ($model === null)
            throw new CHttpException ( 404, 'The requested page does not exist.' );
        return $model;
    }

    /**
     * Performs the AJAX validation.
     *
     * @param Marriage $model
     *            the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'marriage-form')
        {
            echo CActiveForm::validate ( $model );
            Yii::app ()->end ();
        }
    }
}
