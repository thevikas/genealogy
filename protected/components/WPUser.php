<?php

class WPUser extends CWebUser implements IWebUser, IApplicationComponent
{
    public function init ()
    {
        if(php_sapi_name() !== 'cli')
            parent::init();
    }

    function checkAccess ($operation, $params = array())
    {
        if(!function_exists('current_user_can'))
            return false;
        $rt = current_user_can("digiscend_" . $operation);
        if(!$rt)
        {
            $rt = Yii::app()->authManager->checkAccess($operation,$this->getId(),$params);
            error_log(__FILE__ . ":" . __LINE__ . ": - op?" . $operation . " -1 " . $rt);
            return $rt;
        }
        error_log(__FILE__ . ":" . __LINE__ . ": - op?" . $operation . " -2 " . $rt);
        return $rt;
    }

    function getId()
    {
        return get_current_user_id();
    }

    /**
     * 201601281617:vikas:Gurgaon:#374
     */
    public function setId($value)
    {
        return wp_set_current_user($value,'');
    }

    /**
     * If the user is logged in, he should also be setup in yii auth system
     * Or, he is not logged in
     * @see IWebUser::getIsGuest()
     */
    function getIsGuest () {
        if(!function_exists('is_user_logged_in'))
            return false;

        $is_user_logged_in = is_user_logged_in();
        if(!$is_user_logged_in)
        {
            return true;
        }

        $user = wp_get_current_user();
        //check if there are some assignments to the user
        $assignments = Yii::app()->authManager->getAuthAssignments($user->ID);
        if(empty($assignments))
        {
            if(!$this->afterlogin())
            {
                return true;
            }
        }
        return !$is_user_logged_in;
    }

    function getName ()
    {
        $name = wp_get_current_user()->user_login;
        return $name;
    }

    public function loginRequired()
    {
        Yii::app()->request->redirect(wp_login_url( Yii::app()->getRequest()->getUrl()));
    }

    public function logout($destroySession = true)
    {
        wp_logout();
    }

    public function afterlogin($fromCookie = '')
    {
        $current_user = wp_get_current_user();
        if ($current_user->roles [0] == 'administrator')
        {
            if(!Yii::app ()->authManager->checkAccess('admin',$current_user->ID))
            {
                $auth = Yii::app ()->authManager->assign ( 'admin',  $current_user->ID);
                Yii::app ()->authManager->save();
            }
            return true;
        }
        else
        {
            $mats = [ ];
            foreach ( $current_user->allcaps as $cap => $v )
            {
                if (preg_match ( '/^digiscend_role_(\w+)/', $cap, $mats ))
                {
                    if(!Yii::app ()->authManager->checkAccess($mats [1],$current_user->ID))
                    {
                        $auth = Yii::app ()->authManager->assign ( $mats [1], $current_user->ID );
                        Yii::app ()->authManager->save();
                    }
                    return true;
                }
            }
        }
        return false;
    }

    static function canEditCompany($params)
    {
        if(Yii::app()->user->checkAccess(AuthConstants::ROLE_ADMIN))
            return true;
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors','on');
        if(!isset($params['userId']) || $params['userId'] == 0)
        {
            return false;
        }

        if(!isset($params[Company::ACL_PARAM_KEY]) || !is_object($params[Company::ACL_PARAM_KEY]))
        {
            return false;
        }

        $company = $params[Company::ACL_PARAM_KEY];

        if(empty($company))
        {
            return false;
        }

        if(isset($company->id_company) && isset(Yii::app()->user->company->id_company) && Yii::app()->user->company->id_company == $company->id_company)
        {
            return true;
        }

        return false;
    }

    static function canEditProject($params)
    {
        if(Yii::app()->user->checkAccess(AuthConstants::ROLE_ADMIN))
            return true;

        if(!isset($params[Project::ACL_PARAM_KEY]) || !is_object($params[Project::ACL_PARAM_KEY]))
        {
            return false;
        }

        $project = $params[Project::ACL_PARAM_KEY];

        if(!isset($project->selectedCompany->id_company))
        {
            return false;
        }
        $params[Company::ACL_PARAM_KEY] = $project->selectedCompany;
        return self::canEditCompany($params);
    }

    public function getCompany()
    {
        return self::getCompanyForUser($this->id);
    }

    static function getCompanyForUser($wp_user_id)
    {
        $person_id = get_cimyFieldValue ( $wp_user_id, 'DIGISCENDUSER', '' );
        if (empty ( $person_id ))
            return false;
        $per = Person::model ()->findByPk ( $person_id );
        return $per->company;
    }
}
