<?php

/**
 * Just ads a method to all models to dump a html link to view action of their controllers
 * @author vikas
 * 
 * @property Project $owner
 */
class GroupCheckAccessBehavior extends CActiveRecordBehavior
{
    private $owner_gid;

    public function attach($owner)
    {
        parent::attach ( $owner );
    }

    /**
     * Stores the original owner id after a record is loaded.
     * This is to prevent any changes to this field during save
     *
     * {@inheritdoc}
     *
     * @see CActiveRecordBehavior::afterFind()
     */
    public function afterFind($event)
    {
        $this->owner_gid = $this->owner->owner_gid;
    }

    /**
     * Allows setting new owner for new records
     * Checks record owner matches users group
     * Also checks no changes in record owner was made
     *
     * {@inheritdoc}
     *
     * @see CActiveRecordBehavior::beforeSave()
     */
    public function beforeSave($event)
    {
        if ($this->owner->isNewRecord)
            $this->owner->owner_gid = Yii::app ()->user->groupid;
        
        $rt = $this->owner->owner_gid == Yii::app ()->user->groupid;
        if (! $rt)
        {
            $this->owner->addError ( '', __ ( 'Access Denied' ) );
        }
        
        if ($this->owner->owner_gid != $this->owner_gid)
        {
            $this->owner->addError ( 'owner_gid', __ ( 'Cannot be updated' ) );
            $rt = false;
        }
        
        $event->isValid = $rt;
        return false;
    }
}
