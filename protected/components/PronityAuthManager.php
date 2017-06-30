<?php
/**
 * DigiscendAuthManager class file.
 * 201512081602:vikas:#386:Coimbature
 * Inherited from CPhpAuthManager as this one has little different way to execute biz rules
 * @see CPhpAuthManager
 */
class PronityAuthManager extends CPhpAuthManager
{
	/**
	 * Executes the specified business rule.
	 * @param string $bizRule the business rule to be executed.
	 * @param array $params parameters passed to {@link IAuthManager::checkAccess}.
	 * @param mixed $data additional data associated with the authorization item or assignment.
	 * @return boolean whether the business rule returns true.
	 * If the business rule is empty, it will still return true.
	 */
	public function executeBizRule($bizRule,$params,$data)
	{
	    if(!empty($bizRule))
	        return call_user_func($bizRule,$params,$data);
	    //no rule means it has passed
	    return true;
	}

}
