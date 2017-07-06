<?php
/**
 * CRAP on 18Dec15 is 20
 * This behaviour will divert data from the active record into staging logs
 *
 * If a certain project is found under moderation for editors,
 * it will load moderatoed data all those users
 *
 * @author vikasyadav
 * @property array|string $fieldlist Fields list
 */
class StagingBehavior extends CActiveRecordBehavior
{
    /**
     *
     * @var Project|Company
     */
    private $owner;

    /**
     * Owner base class Model class name
     *
     * @var string
     */
    public $owner_type;

    /**
     * The RBACL Operation what has to pass for save event to be allowed.
     * 201512101912:#386:thevikas:Coimbature
     *
     * @var unknown
     */
    public $acl_operation;

    /**
     * The array index name when sending params to checkAccess
     *
     * @var unknown
     */
    public $acl_param_key;

    /**
     * Allowed fields to be saved in staging case
     *
     * @var int|array
     */
    public $allowed_fields;

    /**
     * Readonly fields which should be backed up
     *
     * @var unknown
     */
    public $readonly_fields = [ ];

    /**
     * The field in log entry where the PK of the owner PK will be saved to
     *
     * @var int
     */
    public $log_idkey;
    private $id_moderation_log = 0;

    /**
     * Logtype to use for marking moderation data in log table
     *
     * @var unknown
     */
    public $logtype_for_moderation;

    /**
     * Logtype to use after approval and applying the changes
     * 201603291330:vikas:#422:Gurgaon:to fix some issues
     * @var unknown
     */
    public $logtype_for_after_approval;

    private $backupAttributes;

    public function getbackupAttributes()
    {
        return $this->backupAttributes;
    }

    public function attach($owner)
    {
        parent::attach ( $owner );
        $this->owner = $owner;
        if(empty($this->logtype_for_after_approval) || empty($this->logtype_for_moderation))
        {
            throw new Exception("Logtypes not given in " . __METHOD__ . ' - ' . get_class($owner));
        }
        // if(php_sapi_name() == 'cli' && (!isset(Yii::app()->params['runmode']) || Yii::app()->params['runmode'] !==
        // 'test'))
        // return;

        // if(!Yii::app()->user->isGuest &&
        // !Yii::app()->user->checkAccess(AuthConstants::OPT_NO_MODERATION,[$this->acl_param_key => $this->owner]))
        $owner->attachEventHandler ( 'onAfterFind', [
                $this,
                'onAfterFind'
        ] );

        if (php_sapi_name () != 'cli' ||
                 (isset ( Yii::app ()->params ['runmode'] ) && Yii::app ()->params ['runmode'] == 'test'))
            $owner->attachEventHandler ( 'onBeforeSave', [
                    $this,
                    'onBeforeSave'
            ] );
        // echo __METHOD__ . ",line:" . __LINE__ . "\n";
    }

    public function onAfterFind($event)
    {
        /**
         * **********************************************************************************************
         * Backup all attributes
         */

        // echo __METHOD__ . ",line:" . __LINE__ . "\n";
        // save backup of fields
        $this->backupAttributes = $this->owner->getAttributes ();
        // also force saving all the marked fields too
        foreach ( $this->allowed_fields as $field )
        {
            if (isset ( $this->owner->$field ))
                $this->backupAttributes [$field] = $this->owner->$field;
        }

        $vals = $this->owner->getValidatorList ();

        // echo "starting count:" . $this->owner->getValidatorList()->count . "\n";

        /**
         * **********************************************************************************************
         * Find which validators are on non-existant attributes and delete those validators
         */
        $to_delete_indexes = [ ];

        $ml = $this->owner->ml;
        // adding exception that only when multilang is NOT active, clear up other useless language fields
        // otherwise, when the caller saves intro_es, that fields would have already been removed from a safe validator
        // and cannot be saved. this happens when multilang data for a record is not set while primary data is.
        if (! $this->owner->hasRelated ( $ml->multilangRelation ))
        {

            // verify attributes and validators are in sync
            for($i = 0; $i < $vals->count; $i ++)
            {
                $val = $vals->itemAt ( $i );
                if (count ( $val->attributes ) > 1 || empty ( $val->attributes [0] ))
                    continue;

                $field = $val->attributes [0];

                if (! $this->owner->hasAttribute ( $field ) && ! $this->owner->canGetProperty ( $field ) &&
                         ! property_exists ( $this->owner, $field ) && ! isset ( $this->owner->$field ))
                {
                    // echo "> $field ($a,$b,$c,$d)\n";
                    // echo "To Remove.... index $i\n";
                    $to_delete_indexes [] = $i;
                    // $vals->removeAt($i);
                    // throw new Exception('ddddd');
                }
            }
        }
        // echo "Val count=" . $vals->count . "\n";

        for($i = count ( $to_delete_indexes ) - 1; $i >= 0; $i --)
        {
            // echo "Removing.... index " . $to_delete_indexes[$i] . "\n";
            $vals->removeAt ( $to_delete_indexes [$i] );
        }

        // echo "Val count2=" . $vals->count . "\n";

        // echo "ending count:" . $this->owner->getValidatorList()->count . "\n";

        $pk = $this->owner->tableSchema->primaryKey;

        /**
         * **********************************************************************************************
         * Delete fields from backup which are no supposed to be
         */

        // unsetting the attributes which are marked readonly
        array_map (
                function ($key)
                {
                    unset ( $this->backupAttributes [$key] );
                }, $this->readonly_fields );

        /**
         * **********************************************************************************************
         * Loading data under moderation into current model
         */
        if (isset ( $this->owner->$pk ) && ! empty ( $this->owner->id_moderation_log ))
        {
            // if user can edit this project
            // AND he requires moderation
            // ONLY THEN CHECK for unmoderated data from the logs
            //
            if (Yii::app ()->user->checkAccess ( $this->acl_operation, [
                    $this->acl_param_key => $this->owner
            ] ) && ! Yii::app ()->user->checkAccess ( AuthConstants::OPT_NO_MODERATION,
                    [
                            $this->acl_param_key => $this->owner
                    ] ))
            {
                $log = Log::model ()->find (
                        [
                                'condition' => 'logtype=? and id_log=?',
                                'limit' => '0,1',
                                'order' => 'id_log desc',
                                'params' => [
                                        $this->logtype_for_moderation,
                                        $this->owner->id_moderation_log
                                ]
                        ] );

                if ($log)
                {
                    $data = unserialize ( $log->val );
                    if (is_array ( $data ) && ! empty ( $data ))
                    {
                        foreach($this->allowed_fields as $field)
                        {
                            //201603311927:vikas:#422
                            // SECURITY: added this so that fields that are not allowed,
                            // does not get overwritten by the log injection
                            //
                            // if the owner has the field and
                            // it is allowed and
                            // the data is available in the logs
                            if (isset ( $this->owner->$field ) && !empty($data[$field]))
                            {
                                $this->owner->$field = $data[$field];
                            }
                        }
                    }
                }
            }
        }
    }

    public function onBeforeSave($event)
    {
        // to check if he can save data
        if (! Yii::app ()->user->checkAccess ( $this->acl_operation, [
                $this->acl_param_key => $this->owner
        ] ))
        {
            $event->isValid = false;
            Log::entry ( Log::LOG_BEFORE_SAVE_ACCESS_FAILED,
                    [
                            //201606021127:vikas:#471:Gurgaon:disabling for too big to store
                            //'event' => serialize ( $event ),
                            'acl_key' => $this->acl_param_key,
                            'acl_operation' => $this->acl_operation,
                            'owner_class' => get_class ( $this->owner )
                    ] );
            return;
        }
        // to check where he can save data directly or through moderation
        if (Yii::app ()->user->checkAccess ( AuthConstants::OPT_NO_MODERATION, [
                $this->acl_param_key => $this->owner
        ] ))
        {
            // save directly, let the event handler allow the flow
            // activerecord will save it in the call flow automatically
            $event->isValid = true;
            return;
        }
        else
        {
            // dont save directly, send the diff to logs for moderation
            // and later approval
            // block the call flow so activate record cannot save
            $event->isValid = true;
            $data = $this->doStaging ();
            $pk = $this->owner->tableSchema->primaryKey;
            $pk_id = $this->owner->$pk;
            $this->owner->addError ( 'moderation', __ ( 'Data has been sent for moderation.' ) );
            $data2 = array_merge ( $data,
                    [
                            'pk' => $pk,
                            $pk => $pk_id,
                            'model' => $this->owner_type
                    ] );

            // using constants defined by the host model for the logtype
            // 201512161657:vikas:#368:Cpoimbature
            $log = Controller::$dic->get ( 'Log' )->entry ( $this->logtype_for_moderation, serialize ( $data2 ) );

            if (! $log)
            {
                Yii::log ( __METHOD__ . ":" . __LINE__, CLogger::LEVEL_ERROR,
                        __CLASS__ . '/' . get_class ( $this->owner ) );
                return false;
            }

            $this->id_moderation_log = $log->id_log;
            // echo "Real data::\n";
            // print_r($this->owner->getAttributes());
            // echo "Backup data::\n";
            // print_r($this->backupAttributes);
            // die;
            // reset all attributes to original state
            foreach ( $this->backupAttributes as $name => $val )
            {
                // let the moderation log id be overritten, no preserved to old val
                if ($name == 'id_moderation_log')
                    continue;

                    // error_log("setting $name to $val");
                $this->owner->$name = $val;
            }

            $this->owner->$pk = $pk_id;
            $this->owner->id_moderation_log = $log->id_log;

            $log->params = serialize (
                    [
                            'object_type' => get_class ( $this->owner ),
                            'event' => $event,
                            'id' => $pk_id
                    ] );
            $log->update ( [
                    'params'
            ] );

            // $event->isValid = false;
            if (! empty ( $this->log_idkey ))
            {
                $log->{$this->log_idkey} = $pk_id;
                $log->update ( [
                        $this->log_idkey
                ] );
            }
        }
    }

    public function onAfterSave($event)
    {
    }

    /**
     * This method will simply save data for moderation
     */
    public function doStaging()
    {
        // only certain fields can be saved when moderation is required
        $data = [ ];
        foreach ( $this->allowed_fields as $field )
        {
            if ($this->owner->canGetProperty ( $field ) || property_exists ( $this->owner, $field ) ||
                     $this->owner->hasAttribute ( $field ) || isset ( $this->owner->$field ))
                $data [$field] = $this->owner->$field;
        }
        return $data;
    }

    /**
     * To apply changes given in the log val. does not check ACL here saving is done through normal flow and
     *  since beforesave handler will automatically check everything.
     * 201603271209:vikas:#422:Gurgaon
     * @param unknown $id_log
     */
    public function applyChanges($id_log)
    {
        $log = $this->checkChangeStatus( $id_log );
        if(!is_object($log))
        {
            Yii::log(__METHOD__ . ", check change status (id={$id_log})","error");
            return false;
        }

        $data = unserialize ( $log->val );
        foreach ( $this->allowed_fields as $field )
        {
            if (! empty ( $data [$field] ))
            {
                $this->owner->$field = $data [$field];
            }
        }

        $this->owner->id_moderation_log = null;
        if(!$this->owner->save ())
            return false;

        //now we go to do another log of approval
        Log::entry($this->logtype_for_after_approval, $id_log);
        return true;
    }

    /**
     * To check change status if already appplied,etc
     * 201603271209:vikas:#422:Gurgaon
     * @param unknown $id_log
     */
    public function checkChangeStatus($id_log,$strict = true)
    {
        $log_idkey = $this->log_idkey;
        $log = Log::model ()->findByPk ( $id_log );
        $pk = $this->owner->tableSchema->primaryKey;
        if(!$log)
        {
            Yii::log(__METHOD__ . ", log (id={$id_log}) not found","error");
            return -1;
        }
        if($log->logtype != $this->logtype_for_moderation)
        {
            Yii::log(__METHOD__ . ", wrong logtype (id={$id_log}) sent for approval","error");
            return -2;
        }
        if ($log->$log_idkey != $this->owner->$pk)
        {
            Yii::log(__METHOD__ . ", (id={$id_log}) changes dont belong to this project/company","error");
            return -3;
        }
        //now check if its not already used
        if($strict && Log::model()->count('logtype=? and val=?',[$this->logtype_for_after_approval,$id_log])>0)
        {
            Yii::log(__METHOD__ . ", changes in (id={$id_log}) has been already applied","error");
            return -4;
        }
        return $log;
    }

    /**
     * To return diff that can be rendered for all fields that changed
     * 201603271209:vikas:#422:Gurgaon
     * @see https://github.com/gorhill/PHP-FineDiff
     * @param int $id_log
     */
    public function showChanges($id_log)
    {
        $log = $this->checkChangeStatus( $id_log , false );
        if(!is_object($log))
        {
            Yii::log(__METHOD__ . ", check change status (id={$id_log})","error");
            return false;
        }

        $filepath = Yii::app()->basePath . '/vendor/gorhill/PHP-FineDiff/finediff.php';
        require_once $filepath;

        $diff_opcodes_by_fields = [];

        $data = unserialize ( $log->val );
        foreach ( $this->allowed_fields as $field )
        {
            if (! empty ( $data [$field] ))
            {
                $diff_opcodes_by_fields[$field]['opcodes'] = FineDiff::getDiffOpcodes($this->owner->$field, $data [$field],FineDiff::$wordGranularity);
                $diff_opcodes_by_fields[$field]['html'] = FineDiff::renderDiffToHTMLFromOpcodes($this->owner->$field, $diff_opcodes_by_fields[$field]['opcodes']);
            }
        }

        return $diff_opcodes_by_fields;
    }
}
