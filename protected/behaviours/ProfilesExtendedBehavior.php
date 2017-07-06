<?php

function sanitizeNumericArray($arr)
{
    $arr2 = array ();
    foreach ( $arr as $item )
    {
        $v = intval ( $item );
        if ($v)
            $arr2 [] = $v;
    }
    return $arr2;
}
class ProfilesExtendedBehavior extends CActiveRecordBehavior
{
    public $profileitems_savedata;
    public $entitytype;
    public $relationvar = array (
            ProfileItem::PROFILE_ITEM_MATERIAL => 'material',
            ProfileItem::PROFILE_ITEM_PROJECT => 'project',
            ProfileItem::PROFILE_ITEM_TASK => 'task',
            ProfileItem::PROFILE_ITEM_DEPENDTASK => 'dtask',
            ProfileItem::PROFILE_ITEM_UNIT => 'unit',
            ProfileItem::PROFILE_ITEM_WORKER => 'worker' 
    );

    static function toAscii($str, $replace = array(), $delimiter = '-')
    {
        $str = trim ( $str );
        setlocale ( LC_ALL, 'en_US.UTF8' );
        if (! empty ( $replace ))
        {
            $str = str_replace ( ( array ) $replace, ' ', $str );
        }
        
        @$clean = iconv ( 'UTF-8', 'ASCII//TRANSLIT', $str );
        $clean = preg_replace ( "/[^a-zA-Z0-9\/_|+ -]/", '', $clean );
        $clean = strtolower ( trim ( $clean, '-' ) );
        $clean = preg_replace ( "/[\/_|+ -]+/", $delimiter, $clean );
        
        return $clean;
    }

    public function beforeSave($event)
    {
        $event->isValid = true;
        /*$person = $this;
        
        $owner = $person->getOwner ();
        
        if (! isset ( $owner->slug ) || ! empty ( $owner->slug ))
            return;
            
            // usually slug is from the name field only
        $owner->slug = $this->toAscii ( $owner->name );
        // incase of projects, also put the company name
        if ($owner instanceof Project && isset ( $owner->selectedCompany->name ))
            $owner->slug .= '-' . $this->toAscii ( $owner->selectedCompany->name );
        
        $owner_class = get_class ( $owner );
        
        $pkey = $owner->tableSchema->primaryKey;
        $id = $owner->$pkey;
        
        // to check if the slug is unique in the owner table
        if ($owner_class::model ()->find ( 'slug=?', array (
                $owner->slug 
        ) ))
        {
            $sha1 = sha1 ( $owner->slug . "-" . $id . "-" . time () );
            $unq = substr ( $sha1, 0, 4 );
            $owner->slug = $this->toAscii ( $owner->name . "-$unq" );
        }*/
    }

    public function afterSave($event)
    {
        if (! is_array ( $this->profileitems_savedata ) || ! count ( $this->profileitems_savedata ))
        {
            return;
        }
        
        $pkey = $this->getOwner ()->tableSchema->primaryKey;
        $id = $this->getOwner ()->$pkey;
        
        $this->saveData ( $id );
        $this->profileitems_savedata = array ();
    }
    
    public function onBeforeProfileSave($event)
    {
        $this->raiseEvent('onBeforeProfileSave', $event);
    }

    /**
     * Adds the profile item related to the current owner entity
     * 
     * @param integer $id
     *            PK of the owner entity for which this profile item is been added
     * @return boolean
     */
    public function saveData($id)
    {
        foreach ( $this->profileitems_savedata as $type => $data )
        {
            $dr1 = ProfileItem::model ()->deleteAll ( 'entitytype=? and id_entity=? and type=?', 
                    array (
                            $this->entitytype,
                            $id,
                            $type 
                    ) );
            $dr2 = ProfileItem::model ()->deleteAll ( 'type=? and id_fkey=? and entitytype=?', 
                    array (
                            $this->entitytype,
                            $id,
                            $type 
                    ) );
            
            if (! is_array ( $data ) || count ( $data ) == 0)
            {
                continue;
            }
            
            foreach ( $data as $item )
            {
                $pi = new ProfileItem ();
                $pi2 = new ProfileItem ();
                
                $pi2->id_fkey = $pi->id_entity = $id;
                $pi2->entitytype = $pi->type = $type;
                $pi2->type = $pi->entitytype = $this->entitytype;
                $pi2->id_entity = $pi->id_fkey = $item;
                $pi2->param = $pi->param = '';
                $ex = '';
                $rt = true;
                try
                {
                    $rt = $pi->save ();
                    if (true)
                    {
                        $rt = $pi2->save ();
                    }
                }
                catch ( Exception $e )
                {
                    error_log ( 
                            __METHOD__ . ':' . __LINE__ . ',' . $e->getMessage () . ", dr1=$dr1, dr2=$dr2, data=" .
                                     var_export ( $data, true ) );
                    if (strstr ( $e->getMessage (), '1062 Duplicate entry' ) === NULL)
                    {
                        echo "exception:" . $e->getMessage ();
                        Yii::app ()->end ();
                    }
                    $ex = $e;
                    $rt = false;
                }
                if (count ( $pi->getErrors () ) > 0 && count ( $pi2->getErrors () ) > 0)
                {
                    $rt = false;
                }
                
                if (! $rt)
                {
                    Yii::log ( 
                            'Error saving the profile item:' . var_export ( $pi->getErrors (), true ) . "," .
                                     var_export ( $pi2->getErrors (), true ), 'error' );
                    if ($ex)
                    {
                        Yii::log ( 'Error saving the profile item: exp message:' . $ex->getMessage (), 'error' );
                    }
                    return false;
                }
            }
        }
        
        return true;
    }

    public function searchData($query)
    {
        $entitytype = $this->entitytype;
        
        if (isset ( $query ['id_country'] ))
        {
            if (! is_array ( $query ['id_country'] ) && is_numeric ( $query ['id_country'] ))
            {
                $query ['id_country'] = array (
                        $query ['id_country'] 
                );
            }
            
            if (count ( $query ['id_country'] ))
            {
                $in_ids = implode ( ',', sanitizeNumericArray ( $query ['id_country'] ) );
                if (! empty ( $in_ids ))
                    $pi3_sql = "join profile_items pi3
                            on
                            pi3.id_entity=piA.id_entity
                            and pi3.type='" . ProfileItem::PROFILE_ITEM_COUNTRY . "'
                            and pi3.entitytype='$entitytype'
                            and pi3.id_fkey in ($in_ids)";
            }
        }
        
        if (isset ( $query ['id_sector'] ))
        {
            if (! is_array ( $query ['id_sector'] ) && is_numeric ( $query ['id_sector'] ))
            {
                $query ['id_sector'] = array (
                        $query ['id_sector'] 
                );
            }
            
            if (count ( $query ['id_sector'] ))
            {
                $in_ids = implode ( ',', sanitizeNumericArray ( $query ['id_sector'] ) );
                if (! empty ( $in_ids ))
                    $pi4_sql = "join profile_items pi3
                            on
                            pi3.id_entity=piA.id_entity
                            and pi3.type='" . ProfileItem::PROFILE_ITEM_SECTOR . "'
                            and pi3.entitytype='$entitytype'
                            and pi3.id_fkey in ($in_ids)";
            }
        }
        
        $sql = "SELECT distinct piA.* FROM
        `profile_items` piA
        $pi3_sql
        $pi4_sql
        where piA.entitytype='$entitytype'
        group by piA.id_entity";
        
        switch ($this->entitytype)
        {
            case ProfileItem::PROFILE_ITEM_PROJECT :
                $idfield = "id_project";
                break;
            case ProfileItem::PROFILE_ITEM_MATERIAL :
                $idfield = "id_material";
                break;
            case ProfileItem::PROFILE_ITEM_TASK:
                $idfield = "id_task";
                break;
            case ProfileItem::PROFILE_ITEM_UNIT:
                $idfield = "id_unit";
                break;
            case ProfileItem::PROFILE_ITEM_WORKER :
                $idfield = "id_worker";
                break;
        }
        
        $ids = array ();
        
        $items = ProfileItem::model ()->findAllBySql ( $sql );
        foreach ( $items as $item )
        {
            // ignore the entity that is calling the related items?
            // if($item->entitytype == $this->entitytype)
            // continue;
            $ids [] = $item->id_entity;
        }
        
        $crit = new CDbCriteria ();
        $crit->addInCondition ( $idfield, $ids );
        return $crit;
    }

    /**
     * Person
     * ==========================================
     *
     * @return multitype:NULL
     */
    public function getProfilePeople()
    {
        if (isset ( $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_PERSON] ))
            return $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_PERSON];
        return $this->filterKeys ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_PERSON );
    }

    public function getProfilePeopleObjects()
    {
        return $this->filterKeysObjects ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_PERSON, 'person' );
    }

    public function setProfilePeople($data)
    {
        if (empty ( $data ))
            return;
        
        if (! is_array ( $data ) && ! empty ( $data ))
        {
            Yii::log ( "setting people with $data[0]", 'info' );
            $data = array (
                    $data 
            );
        }
        $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_PERSON] = array_unique ( $data, SORT_NUMERIC );
    }
    
    /**
     * Material
     * ==========================================
     * 
     * @return multitype:NULL
     */
    public function getProfileMaterials()
    {
        if (isset ( $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_MATERIAL] ))
            return $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_MATERIAL];
        return $this->filterKeys ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_MATERIAL );
    }

    public function getProfileMaterialObjects()
    {
        return $this->filterKeysObjects ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_MATERIAL, 'material' );
    }

    public function setProfileMaterials($data)
    {
        if (empty ( $data ))
            return;
        
        if (! is_array ( $data ) && ! empty ( $data ))
        {
            Yii::log ( "setting countries with $data[0]", 'info' );
            $data = array (
                    $data 
            );
        }
        $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_MATERIAL] = array_unique ( $data, SORT_NUMERIC );
    }

    
    /**
     * PROJECT
     * ==========================================
     * 
     * @return multitype:NULL
     */
    public function getProfileProjects()
    {
        if (isset ( $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_PROJECT] ))
            return $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_PROJECT];
        return $this->filterKeys ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_PROJECT );
    }

    public function getProfileProjectObjects()
    {
        return $this->filterKeysObjects ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_PROJECT, 
                'project' );
    }

    public function setProfileProjects($data)
    {
        if (empty ( $data ))
            return;
        
        if (! is_array ( $data ))
            Yii::log ( "setting projects with $data", 'info' );
        if (! is_array ( $data ) && ! empty ( $data ))
            $data = array (
                    $data 
            );
        $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_PROJECT] = array_unique ( $data, SORT_NUMERIC );
    }

    /**
     * Unit
     * ==========================================
     * 
     * @return multitype:NULL
     */
    public function getProfileUnits()
    {
        if (isset ( $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_UNIT] ))
            return $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_UNIT];
        return $this->filterKeys ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_UNIT );
    }

    public function getProfileUnitObjects()
    {
        return $this->filterKeysObjects ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_UNIT, 'unit' );
    }

    public function setProfileUnits($data)
    {
        if (empty ( $data ))
            return;
        
        if (! is_array ( $data ) && ! empty ( $data ))
            $data = array (
                    $data 
            );
        $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_TASK] = array_unique ( $data, SORT_NUMERIC );
    }
    
    /**
     * Worker
     * ==========================================
     *
     * @return multitype:NULL
     */
    public function getProfileWorkers()
    {
        if (isset ( $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_WORKER] ))
            return $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_WORKER];
            return $this->filterKeys ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_WORKER );
    }
    
    public function getProfileWorkerObjects()
    {
        return $this->filterKeysObjects ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_WORKER, 'worker' );
    }
    
    public function setProfileWorkers($data)
    {
        if (empty ( $data ))
            return;
    
            if (! is_array ( $data ) && ! empty ( $data ))
                $data = array (
                        $data
                );
                $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_WORKER] = array_unique ( $data, SORT_NUMERIC );
    }
    
    /**
     * Task
     * ==========================================
     * 
     * @return multitype:NULL
     */
    public function getProfileTasks()
    {
        if (isset ( $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_TASK] ))
            return $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_TASK];
        return $this->filterKeys ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_TASK );
    }

    public function getProfileTaskObjects()
    {
        return $this->filterKeysObjects ( $this->getOwner ()->profileitems, ProfileItem::PROFILE_ITEM_TASK, 'task' );
    }

    public function setProfileTasks($data)
    {
        if (empty ( $data ))
            return;
        
        if (! is_array ( $data ) && ! empty ( $data ))
            $data = array (
                    $data 
            );
        $this->profileitems_savedata [ProfileItem::PROFILE_ITEM_TASK] = array_unique ( $data, SORT_NUMERIC );
    }    

    /**
     * ==========================================
     * 
     * @param unknown $items            
     * @param unknown $keytype            
     * @return multitype:NULL
     */
    public function filterKeys($items, $keytype)
    {
        $arr = array ();
        foreach ( $items as $item )
        {
            if ($item->type == $keytype && $item->id_fkey)
                $arr [] = $item->id_fkey;
        }
        Yii::log ( 
                "found keys($keytype) total:" . count ( $arr ) . " items of " . count ( 
                        $this->getOwner ()->profileitems ) . " items" );
        // return array(518);
        return $arr;
    }

    /**
     *
     * @param unknown $items            
     * @param unknown $keytype            
     * @param unknown $property
     *            This is the keyname as specificed in profileitem model relations
     * @return multitype:NULL
     */
    public function filterKeysObjects($items, $keytype, $property)
    {
        $arr = array ();
        foreach ( $items as $item )
        {
            if ($item->type == $keytype && $item->id_fkey)
            {
                if (! empty ( $item->$property ))
                    $arr [] = $item->$property;
            }
        }
        Yii::log ( 
                "found keys($keytype) total:" . count ( $arr ) . " items of " . count ( 
                        $this->getOwner ()->profileitems ) . " items" );
        return $arr;
    }

    public function getContentLink()
    {
        switch ($this->entitytype)
        {
            case ProfileItem::PROFILE_ITEM_PERSON :
                return Yii::app ()->createUrl ( '/profile/person', array (
                        'slug' => $this->getOwner ()->slug 
                ) );
            case ProfileItem::PROFILE_ITEM_IIPRODUCT :
                return Yii::app ()->createUrl ( '/product/content', array (
                        'id' => $this->getOwner ()->id_product 
                ) );
            case ProfileItem::PROFILE_ITEM_DEBATE :
                return Yii::app ()->createUrl ( '/dialogue/content', array (
                        'id' => $this->getOwner ()->id_dialogue 
                ) );
            case ProfileItem::PROFILE_ITEM_DEPARTMENT :
                return Yii::app ()->createUrl ( '/department/content', array (
                        'id' => $this->getOwner ()->id_department 
                ) );
            case ProfileItem::PROFILE_ITEM_BOXNEWS :
                return Yii::app ()->createUrl ( '/news/content', array (
                        'id' => $this->getOwner ()->id_news 
                ) );
            case ProfileItem::PROFILE_ITEM_INTELLIGENCE :
                return Yii::app ()->createUrl ( '/intelligence/content', 
                        array (
                                'id' => $this->getOwner ()->id_intelligence 
                        ) );
            default :
                return Yii::app ()->createUrl ( '/site/home' );
        }
    }

    public function checkUserOwner()
    {
        $loginuser = Yii::app ()->user->getState ( 'usermodel' );
        if (! $loginuser || ! $loginuser->person)
        {
            Yii::log ( __METHOD__ . ":" . __LINE__ );
            return false;
        }
        
        $person = $loginuser->person;
        Yii::log ( __METHOD__ . ":" . __LINE__ . ", current person=" . $person->id_person );
        if ($this->entitytype == ProfileItem::PROFILE_ITEM_PERSON && $this->getOwner ()->id_person == $person->id_person)
        {
            Yii::log ( __METHOD__ . ":" . __LINE__ );
            return true;
        }
        
        // if this is person, it should be current person
        // else this should be authored by current person
        $people = $this->getOwner ()->profilepeopleobjects;
        
        if (is_array ( $people ) && count ( $people ) > 0)
        {
            Yii::log ( __METHOD__ . ":" . __LINE__ );
            foreach ( $people as $iperson )
            {
                if ($iperson->id_person == $person->id_person)
                {
                    Yii::log ( __METHOD__ . ":" . __LINE__ );
                    return true;
                }
            }
        }
        Yii::log ( __METHOD__ . ":" . __LINE__ );
        return false;
    }
}
