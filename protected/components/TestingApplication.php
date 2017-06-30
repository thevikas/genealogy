<?php
class TestingApplication extends CWebApplication
{
    public function resetCoreComponents()
    {
        parent::registerCoreComponents();
    }
}