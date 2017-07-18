<?php
class WebUser extends CWebUser implements IWebUser, IApplicationComponent
{
    private $groupid;

    public function login($identity, $duration = 0)
    {
        $rt = parent::login ( $identity, $duration );
        if ($rt && $identity->groupid)
            $this->setState ( '__gid', $identity->groupid );
        return $rt;
    }

    /**
     * Returns a value that uniquely represents the user.
     *
     * @return mixed the unique identifier for the user. If null, it means the
     *         user is a guest.
     */
    public function getgroupid()
    {
        return $this->getState ( '__gid' );
    }
}
