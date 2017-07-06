<?php
/**
 * Scatters the update to other tasks down which are linked via output=>input 
 * via match-output or keep-ratio flags
 * Complexity 380 @ 201610241343
 * @author vikas
 */
class TriggerBehavior extends CActiveRecordBehavior
{
    var $controller;
    var $namefield;
    var $cacheprefix;
    var $owner;
    private $SALT = 'NameLinkBehavior';

    public function attach($owner)
    {
        parent::attach ( $owner );
        $this->owner = $owner;
    }

    public function changeRelatedInputs()
    {
        $tms = TaskMaterial::model ()->with ( [ 
                'task' 
        ] )->findAll ( 
                [ 
                        'condition' => 'task.id_project=:proj and mtype=:mtype and id_material=:mat and units_rel=:rel',
                        'params' => [ 
                                'proj' => $this->owner->task->id_project,
                                'mat' => $this->owner->id_material,
                                'mtype' => TaskMaterial::MTYPE_INPUT,
                                'rel' => TaskMaterial::RELUNIT_MATCH_TO_OUTPUT 
                        ] 
                ] );
        
        if (! empty ( $tms ))
        {
            $tmsids = CHtml::listData ( $tms, 'id_tm', 'id_tm' );
            error_log ( 
                    __METHOD__ . ": MyID: {$this->owner->id_tm}, setting on IDs:" . print_r ( $tmsids, true ) .
                             ", xunits= " . $this->owner->xunits );
            
            $this->changeRelatedInputsIterate ( $tms );
        }
    }

    /**
     * Complexity 56 @ 201610241343
     * Complexity 5.02 @ 201610242305
     * 
     * @param TaskMaterial[] $tms            
     */
    public function changeRelatedInputsIterate($tms)
    {
        foreach ( $tms as $tm )
        {
            if (get_class ( $this->owner ) == 'GnattDay')
            {
                $dk = $this->owner->date;
                $cond = [];
                $attr['type'] = 'EXEC';
                $attr['id_taskmaterial'] = $tm->id_tm; 
                //if the input is processed the same day it is produced
                if(!$tm->requiresfullbalance)
                    $attr['date'] = $dk;
                //if the input is processed the next day
                else 
                    $cond = [
                            'condition' => 'date > :dk',
                            'order' => 'date asc',
                            'params' => ['dk' => $dk],
                    ];
                    
                /** @var $gd GnattDat */
                $gd = GnattDay::model ()->findByAttributes ($attr,$cond);
                //if ($tm->mtype == TaskMaterial::MTYPE_INPUT)
                $gd->consumed = $this->owner->produced;
                $gd->adjust_method = $this->owner->adjust_method;
                /*else
                    $gd->produced = $this->owner->produced;*/
                if(!$gd->save())
                {
                    error_log(print_r($gd->errors,true));
                    error_log(print_r($gd,true));
                    throw new Exception(array_pop($gd->errors)[0]);                    
                }
                error_log ( __METHOD__ . ": MyGnattID: {$this->owner->id_tm}, setting xunits {$this->owner->produced}" );
            }
            else
            {
                error_log ( __METHOD__ . ": MyID: {$this->owner->id_tm}, setting xunits {$this->owner->xunits}" );
                $tm->xunits = $this->owner->xunits;
                if(!$tm->save ())
                {
                    print_r($tm->getErrors());
                    die(__METHOD__ . ":" . __LINE__ . " update failed!");
                }
            }
        }
    }

    public function changeRelatedOutputsKeepingRatio()
    {
        error_log ( __METHOD__ . ": for " . get_class ( $this->owner ) . ":" . $this->owner->id );
        // resetting the units in all ratio dependent outputs of the same
        // task
        $tms = TaskMaterial::model ()->findAllByAttributes ( 
                [ 
                        'mtype' => TaskMaterial::MTYPE_OUTPUT,
                        'id_task' => $this->owner->id_task,
                        'units_rel' => TaskMaterial::RELUNIT_KEEP_RATIO 
                ] );
        if (! empty ( $tms ) && is_array ( $tms ))
        {
            error_log ( __METHOD__ . ': calling changeRelatedOutputsKeepingRatioIterate');
            $this->changeRelatedOutputsKeepingRatioIterate ( $tms );
        }
    }

    /**
     * Complexity 56 @ 201610241343
     * 
     * @param unknown $tms            
     */
    public function changeRelatedOutputsKeepingRatioIterate($tms)
    {
        foreach ( $tms as $tm )
        {
            error_log ( __METHOD__ . ': calling tm=' . $tm->id_tm);
            if (! $tm->io_ratio || $tm->isUnitFormula ())
                continue;
            
            if (get_class ( $this->owner ) == 'GnattDay')
            {
                $dk = $this->owner->date;
                $gd = GnattDay::model ()->findByAttributes ( 
                        [ 
                                'date' => $dk,
                                'type' => 'EXEC',
                                'id_taskmaterial' => $tm->id_tm 
                        ] );
                if(!$gd)
                    continue;
                $gd->adjust_method = $this->owner->adjust_method;
                $gd->produced = $this->owner->consumed / $tm->io_ratio;
                if(!$gd->save())
                {
                    error_log(print_r($gd->errors,true));
                    error_log(print_r($gd,true));
                    throw new Exception(array_pop($gd->errors)[0]);                    
                }
                error_log ( 
                        __METHOD__ .
                                 ": MyGnattID: {$this->owner->id_tm}, setting ratio on on ID:{$tm->owner->id_tm} value:{$gd->produced}" );
            }
            else
            {
                if (! $tm->io_ratio || $tm->isUnitFormula ())
                    continue;
                $tm->xunits = $this->owner->xunits / $tm->io_ratio;
                error_log ( 
                        __METHOD__ .
                                 ": MyID: {$this->owner->id_tm}, setting ratio on on ID:{$tm->owner->id_tm} value:{$tm->xunits}" );
                if(!$tm->save())
                {
                    error_log(print_r($tm->errors,true));
                    error_log(print_r($tm,true));
                    throw new Exception(array_pop($tm->errors)[0]);                    
                }
            }
        }
    }

    /**
     * Complexity 56 @ 201610241343
     * 
     * {@inheritDoc}
     *
     * @see CActiveRecordBehavior::afterSave()
     */
    public function afterSave($event)
    {
        error_log ( __METHOD__ . ": for " . get_class ( $this->owner ) . ":" . $this->owner->id );
        if ($this->owner->isNewRecord)
            return;
            
        // MATCH OUTPUT
        // check if there is a taskmaterial marked as match output
        // set the unit of that tm like this one
        if (TaskMaterial::MTYPE_OUTPUT == $this->owner->mtype)
        {
            $this->changeRelatedInputs ();
        }
        // KEEP RATIO
        else if (TaskMaterial::MTYPE_INPUT == $this->owner->mtype)
        {
            $this->changeRelatedOutputsKeepingRatio ();
        }
    }
}
