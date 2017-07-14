<?php

/**
 * Just ads a method to all models to dump a html link to view action of their controllers
 * @author vikas
 */
class NameLinkBehavior extends CActiveRecordBehavior
{
    var $controller;
    var $namefield;
    var $cacheprefix;
    var $template = "";
    var $callback = false;

    private $SALT = 'NameLinkBehavior';

    public function attach($owner)
    {
        parent::attach ( $owner );
    }

    public function getnamelink($params0 = [], $linkprops = [])
    {
        $params = array_merge(array_flip($params0),$params0);

        list ( $name, $id ) = $this->namelinkprops ();
        $linkparams = [
                $this->controller . '/view',
                'id' => $id
        ];
        if (! empty ( $params ))
            $linkparams = array_merge ( $linkparams, $params );

        $model = $this->getOwner ();

        if (empty ( $linkprops ['class'] ))
            $linkprops ['class'] = '';

        $linkprops ['class'] .= ' nl ' . get_class ( $model );
        
        $linkhtml = $name;
        if(!isset($params['nolink']))
            $linkhtml = CHtml::link ( $name, $linkparams, $linkprops );
        
        if(empty($this->template))
            return $linkhtml;

        $mats = [];
        if(!preg_match_all("/{(?<prop>\w+)}/", $this->template,$mats))
            return $linkhtml;
        if(empty($mats['prop']))
            return $linkhtml;

        $output = $this->template;

        foreach($mats['prop'] as $prop)
        {
            $v = "";
            $propname = strtolower($prop);
            if($propname == 'link')
                $v = $linkhtml;
            elseif(!empty($this->owner->$propname))
                $v = $this->owner->$propname;

            $output = str_replace("{" . $prop . "}", $v, $output);
        }
        if(!$this->callback) $output = $this->callback($output,$this->owner,$params);

        return $output;
    }

    public function namelinkprops()
    {
        $model = $this->getOwner ();
        $pk = $model->tableSchema->primaryKey;
        if (! empty ( $model->name ))
            $name = CHtml::encode ( $model->name );
        else
            $name = $model->$pk;

        return [
                $name,
                $model->$pk
        ];
    }

    public function getnameupdatelink()
    {
        list ( $name, $id ) = $this->namelinkprops ();

        return CHtml::link ( $name,
                [
                        $this->controller . '/update',
                        'id' => $id
                ] );
    }

    public function getid()
    {
        $model = $this->getOwner ();
        $pk = $model->tableSchema->primaryKey;
        return $model->$pk;
    }

    public function cacheByAttributes($attrs, $cond = [], $params = [])
    {
        return $this->owner->cache ( Yii::app ()->params ['cachetime'] )->findByAttributes ( $attrs, $cond, $params );
    }

    public function cacheByPk($id)
    {
        if (empty ( $this->cacheprefix ))
            $this->cacheprefix = get_class ( $this->owner );
        return $this->cache2 ( $this->cacheprefix . $id )->findByPk ( $id );
    }

    /**
     *
     * @param CModelEvent $event
     */
    public function afterSave($event)
    {
        $main_owner = $this->getOwner ();
        $ownerPk = $main_owner->getPrimaryKey ();
        $key=$this->getcachedepkey ( $ownerPk );
        Yii::app ()->setGlobalState ( $key, time () );
        //if (isset ( $main_owner->id_project ) && get_class($main_owner) != 'Project')
        //    Yii::app ()->setGlobalState ( $this->getcachedepkey ( $ownerPk,'Project' ), time () );
    }

    /**
     * Returns a global state cache dependency object with proper key
     *
     * @param string $depid
     *            PK to be used in generating key, default: owner's PK.
     */
    public function getcachedepkey($depid = '', $classname = '')
    {
        if (empty ( $classname ))
            $classname = get_class ( $this->owner );
        return $classname . (empty ( $depid ) ? $this->getid () : $depid);
    }

    /**
     * Returns a global state cache dependency object with proper key
     *
     * @param string $depid
     *            PK to be used in generating key, default: owner's PK.
     */
    public function getcachedep($depid = '')
    {
        if(is_numeric($depid))
            $key=$this->getcachedepkey ( $depid );
        else
            $key = $depid;
        return new CGlobalStateCacheDependency ( $key );
    }

    public function cache2($depid = '')
    {
        return $this->owner->cache ( Yii::app ()->params ['cachetime'], $this->getcachedep ( $depid ) );
    }
}
