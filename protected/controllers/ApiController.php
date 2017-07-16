<?php
class ApiController extends Controller
{

    /**
     * (non-PHPdoc)
     *
     * @see CController::actions()
     */
    public function actions()
    {
        return [ ];
    }

    public function behaviors()
    {
        return array ();
    }

    public function beforeAction($action)
    {
        if (! defined ( 'UNIT_TESTING' ))
        {
            // header ( "Cache-Control: public, max-age=86400" );
            // header ( "Pragma: cache" );
        }
        return parent::beforeAction ( $action );
    }

    /**
     * Returns currently logged in user info
     *
     * @param string $id
     *            htmlid code
     * @return boolean
     */
    public function actionUser()
    {
        /** @var Project */
        $obj = Person::model ( 'PersonView' )->findByPk ( PersonView::fromhtmlid ( 1 ) );
        if (! $obj)
            throw new CHttpException ( 404, 'The requested page does not exist.' );
        $attrs = $obj->attrs;
        
        $this->render ( 'json', [ 
                'data' => $attrs 
        ] );
    }

    function addFilters(CDbCriteria &$crit, $country, $stage, $mineral, $project_alias)
    {
        // echo "debug: $country, $stage, $mineral\n";
        $params = [ ];
        if (! empty ( $country ))
        {
            $country = str_replace ( '-', ' ', $country );
            $code1 = Country::model ()->bycountrygroups ( $country )->find ();
            if ($code1)
            {
                $countryCode = $code1->countryCode;
                $crit->addCondition ( ' country_code=:ccode ' );
                $params ['ccode'] = $countryCode;
            }
        }
        
        if (! empty ( $stage ))
        {
            $stage = str_replace ( '-', ' ', $stage );
            $status1 = Status::model ()->find ( "name=?", [ 
                    $stage 
            ] );
            if ($status1)
            {
                $stageid = $status1->id_status;
                $crit->join .= "\n JOIN project_status ps on ps.id_project=$project_alias.id_project ";
                $crit->addCondition ( " ps.id_status=:statusid " );
                $params ['statusid'] = $stageid;
            }
        }
        
        if (! empty ( $mineral ))
        {
            $mineral = str_replace ( '-', ' ', $mineral );
            $mineral1 = Tag::model ()->byminerals ()->find ( "name=:tagname", 
                    [ 
                            'tagname' => $mineral 
                    ] );
            if ($mineral1)
            {
                $tagid = $mineral1->id_tag;
                $crit->join .= "\n JOIN mines_by_metals pm on pm.id_project=$project_alias.id_project ";
                $crit->addCondition ( " pm.id_tag=:tagid " );
                $params ['tagid'] = $tagid;
            }
        }
        return $params;
    }

    /**
     * Will list countries
     *
     * @return boolean
     */
    public function doFilter($crit, $modelObject, $collectionName)
    {
        $crit->order = 'pctr desc,p.ctr_children desc';
        /** @var Project */
        $params = [ ];
        
        $crit->params = array_merge ( $params, $crit->params );
        global $very_bad_global_variable_I_KNOW_doRelations;
        $very_bad_global_variable_I_KNOW_doRelations = false;
        
        // print_r($crit);die;
        $rt = [ ];
        $objs = $modelObject->findAll ( $crit );
        
        foreach ( $objs as $p )
        {
            $rt [] = $p->attrs;
        }
        
        // print_r($rt);die;
        
        $this->render ( 'json', 
                [ 
                        'data' => [ 
                                $collectionName => $rt 
                        ] 
                ] );
        return true;
    }

    /**
     * Displays the contact page
     */
    public function actionSearch()
    {
        $q = $_REQUEST ['q'];
        // search in project name
        $ps = Controller::$dic->get ( 'ProjectSearch' );
        $dp = $ps->search ( 0, $q );
        $response = [ ];
        if (count ( $dp ) == 1)
        {
            $link = $this->createAbsoluteUrl ( 'admin/aproject/super', 
                    [ 
                            'id' => $dp [0] ['id'] 
                    ] );
            $response ['type'] = 'goto';
            $response ['link'] = $link;
        }
        else
        {
            $response ['type'] = 'html';
            $response ['html'] = $this->render ( 'ajax_searchresult', 
                    [ 
                            'results' => $dp 
                    ], true );
        }
        $this->render ( '//api/json', [ 
                'data' => $response 
        ] );
    }

    public function createPerson($id_person)
    {
        error_reporting ( E_ALL | E_STRICT );
        ini_set ( 'display_errors', 'on' );
        if ($id_person)
            $per = Person::model ()->findByPk ( $id_person );
        else
            $per = new Person ();
        $per->attributes = $_POST;
        if (! $per->save ())
        {
            error_log ( "Error during save" . var_export ( $per->getErrors (), true ) );
            print_r ( $per->getErrors () );
            return false;
        }
        error_log ( "Person ID was generated: {$per->id_person}" );
        return $this->renderPerson ( $per->id_person );
    }

    public function renderPerson($id = 0, $key2 = '', $id2 = 0)
    {
        $obj = false;
        /** @var Update */
        if ($id)
            $obj = Person::model ( 'PersonView' )->findByPk ( PersonView::fromhtmlid ( $id ) );
        else if ($id2)
            return $this->actionPeople ( $id2 );
        if (! $obj)
            throw new CHttpException ( 404, 'The requested page does not exist.' );
        $attrs = $obj->getattrs ( true );
        /*
         * @todo Implement projects assigned to people here
         * foreach($obj->projects as $proj)
         * {
         * $attrs['projects'][] = $proj->attrs;
         * }
         */
        $this->render ( 'json', [ 
                'data' => $attrs 
        ] );
        return true;
    }

    /**
     *
     * @param string $id
     *            htmlid code
     * @return boolean
     */
    public function actionPerson($id = 0, $key2 = '', $id2 = 0)
    {
        error_log ( var_export ( $_REQUEST, true ) );
        if (Yii::app ()->request->isPostRequest)
        {
            return $this->createPerson ( $id );
        }
        return $this->renderPerson ( $id, $key2, $id2 );
    }

    /**
     *
     * @param string $id
     *            htmlid code
     * @return boolean
     */
    public function actionManage($id2)
    {
        error_log ( var_export ( $_REQUEST, true ) );
        if (! Yii::app ()->request->isPostRequest)
            throw new CHttpException ( 405 );
        $obj = Person::model ( 'PersonView' )->findByPk ( PersonView::fromhtmlid ( $id2 ) );
        if (! $obj)
            throw new CHttpException ( 404, 'The requested page does not exist.' );
        error_reporting ( E_ALL | E_STRICT );
        ini_set ( 'display_errors', 'on' );
        
        $project_ids = [ ];
        
        foreach ( explode ( '&', file_get_contents ( 'php://input' ) ) as $keyValuePair )
        {
            list ( $key, $value ) = explode ( '=', $keyValuePair );
            if ($key == 'id_project')
                $project_ids [] = $value;
        }
        
        $obj->profileprojects = $project_ids;
        if (! $obj->save ())
        {
            error_log ( "Error during save" . var_export ( $obj->getErrors (), true ) );
            print_r ( $obj->getErrors () );
            return false;
        }
        error_log ( "Person ID was generated: {$obj->id_person}" );
        return $this->renderPerson ( $id2 );
    }

    /**
     *
     * @return boolean
     */
    public function actionPeople()
    {
        /** @var Project */
        $crit = new CDbCriteria ( array (
                // 'order' => ' t.ctr_children DESC,t.updated DESC ',
                'limit' => 25 
        ) );
        // 'condition' => ' id_parent_project is null '
        
        /** @var PersonView */
        $rt = [ ];
        $objs = Person::model ( 'PersonView' )->findAll ( $crit );
        foreach ( $objs as $obj )
        {
            $rt [] = $obj->getattrs ( true );
        }
        
        $this->render ( 'json', [ 
                'data' => $rt 
        ] );
        
        return true;
    }
}
