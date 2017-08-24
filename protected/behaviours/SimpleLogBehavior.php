<?php

/**
 * Just ads a method to all models to dump a html link to view action of their controllers
 * @author vikas
 */
class SimpleLogBehavior extends CActiveRecordBehavior
{
    var $controller;
    var $callback = false;
    var $ltype_create;
    var $ltype_update;

    public function attach($owner)
    {
        parent::attach ( $owner );
    }

    public function afterSave($event)
    {
        $pk = $this->owner->tableSchema->primaryKey;
        $pkval = $this->owner->$pk;

        Logs::l($this->owner->isNewRecord ? $this->ltype_create : $this->ltype_update,$pkval);
    }
}
