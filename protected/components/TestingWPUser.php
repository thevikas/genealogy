<?php

class TestingWPUser extends WPUser implements IWebUser, IApplicationComponent
{
    var $_id;

    function checkAccess ($operation, $params = array())
    {
        if(!function_exists('current_user_can'))
            return false;
        $rt = current_user_can("digiscend_" . $operation);
        if(!$rt)
        {
            return Yii::app()->authManager->checkAccess($operation,$this->getId(),$params);
        }
        return $rt;
    }

    function getId()
    {
        return $this->_id;
    }

    /**
     * 201601281617:vikas:Gurgaon:#374
     */
    public function setId($value)
    {
        return $this->_id = $value;
    }

}
