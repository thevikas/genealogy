<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    var $groupid = 0;

    /**
     * This is right now the most simple ACL system.
     * Not production quality.
     * All users will have to be manually set in the text file
     * Passwords are md5 salted
     *
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $users = [ ];
        $fh = fopen ( Yii::app ()->basePath . '/data/users.txt', 'r' );
        $groups = [ ];
        $lc = 1;
        $this->groupid = 0;
        while ( ! feof ( $fh ) )
        {
            $cols = fgetcsv ( $fh );
            if ($cols [0] [0] == '#')
                continue;
            $users [$cols [0]] = $cols [1];
            $groups [$cols [0]] = $cols [2];
        }
        
        if (! isset ( $users [$this->username] ))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif ($users [$this->username] !== md5 ( Yii::app ()->params ['pass_salt'] . $this->password ))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->groupid = $groups [$this->username];
            $this->errorCode = self::ERROR_NONE;
        }
        return ! $this->errorCode;
    }
}
