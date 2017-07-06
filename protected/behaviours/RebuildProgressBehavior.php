<?php

/**
 * Just ads a method to all models to dump a html link to view action of their controllers
 * @author vikas
 */
class RebuildProgressBehavior extends CBehavior
{
    var $controller;
    var $namefield;
    var $cacheprefix;
    private $SALT = 'NameLinkBehavior';
    
    public function attach($owner)
    {
        parent::attach ( $owner );
    }

    public function 
}
