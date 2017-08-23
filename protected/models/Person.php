<?php

/**
 * This is the model class for table "gene.persons".
 *
 * The followings are the available columns in table 'gene.persons':
 * @property integer $cid
 * @property string $firstname
 * @property integer $father_cid
 * @property integer $mother_cid
 * @property string $created
 * @property integer $deleted
 * @property string $lastname
 * @property integer $gender
 * @property string $name
 * @property string $dob
 * @property string $dod
 * @property integer $bPics
 * @property string $treepos
 * @property integer $isDead
 * @property string $address
 * @property string $phone_mobile
 * @property string $phone_res
 * @property string $phone_off
 * @property string $father_root
 * @property string $updated
 * @property integer $owner_gid
 *
 * The followings are the available model relations:
 * @property Eventdates[] $eventdates
 * @property Marriages[] $marriages1
 * @property Marriages[] $marriages2
 * @property Person $fatherC
 * @property Person[] $persons
 * @property Person $motherC
 * @property Person[] $persons1
 * @property Pics[] $pics
 * @property Person[] $spouses
 * @property Person[] $children
 * @property Person[] $grandchildren
 * @property Person[] $greatgrandchildren
 * @property array $D3
 */
class Person extends CActiveRecord
{
    static $maxlevels = 0;
    var $queryvar1;

    public function behaviors()
    {
        return array (
                'GroupCheckAccessBehavior' => [
                        'class' => 'GroupCheckAccessBehavior'
                ],
                'NameLinkBehavior' => array (
                        'class' => 'application.behaviours.NameLinkBehavior',
                        'controller' => 'person',
                        'template' => '{link}',
                        'callback' => function ($str, $model, $params)
                        {
                            #20170803:vikas:ggn:added nice age to namelink
                            if (!empty($model->dob))
                            {
                                $str .= ' ' . $model->niceage;
                            }
                            if (! isset ( $params ['nospouse'] ))
                            {
                                $spouses = array_merge ( $model->husbands, $model->wives );
                                if (count ( $spouses ) == 1)
                                {
                                    $mage = '';
                                    if ($spouses [0]->gender)
                                        $marriage = Marriage::model ()->findByAttributes (
                                                [
                                                        'husband_cid' => $spouses [0]->cid,
                                                        'wife_cid' => $model->cid
                                                ] );
                                    else
                                        $marriage = Marriage::model ()->findByAttributes (
                                                [
                                                        'husband_cid' => $model->cid,
                                                        'wife_cid' => $spouses [0]->cid
                                                ] );
                                    if (! empty ( $marriage->dom ))
                                    {
                                        $mage = '(' . $marriage->niceage . ')';
                                    }

                                    $mlink = '';
                                    if(!empty($marriage))
                                        $mlink = CHtml::link ( CHtml::image ( '/images/marriage.gif' ),
                                                [
                                                        '/marriage/view',
                                                        'id' => $marriage->mid
                                                ] );

                                    if (! empty ( $params ['flip'] ))
                                        $str = $spouses [0]->getnamelink (
                                                [
                                                        'nospouse' => 1
                                                ] ) . ' ' . $mlink . $mage . ' ' . $str;
                                    else
                                        $str .= ' ' . $mlink . $mage . ' ' . $spouses [0]->getnamelink (
                                                [
                                                        'nospouse' => 1
                                                ] );
                                }
                            }
                            $alive = empty($model->dod) ? '' : 'dead_';
                            $str = CHtml::image ( $model->gender ? "/images/{$alive}man_icon.gif" : "/images/{$alive}woman_icon.gif" ) . $str;
                            return $str;
                        }
                )
        );
    }

    public function beforeSave()
    {
        $this->name = $this->firstname . ' ' . $this->lastname;

        $this->dob = empty ( $this->dob ) ? null : $this->dob;
        $this->dod = empty ( $this->dod ) ? null : $this->dod;

        return parent::beforeSave ();
    }

    public function getspouses()
    {
        return array_merge ( $this->husbands, $this->wives );
    }

    public function getmarriages()
    {
        return array_merge ( $this->marriages1, $this->marriages2);
    }

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'persons';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array (
                array (
                        'father_cid, mother_cid, deleted, gender, bPics, isDead',
                        'numerical',
                        'integerOnly' => true
                ),
                array (
                        'firstname, lastname, name',
                        'length',
                        'max' => 255
                ),
                array (
                        'treepos, father_root',
                        'length',
                        'max' => 10
                ),
                array (
                        'address',
                        'length',
                        'max' => 250
                ),
                array (
                        'phone_mobile, phone_res, phone_off',
                        'length',
                        'max' => 20
                ),
                array (
                        'created, dob, dod',
                        'safe'
                ),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be
                // searched.
                array (
                        'cid, firstname, father_cid, mother_cid, created, deleted, lastname, gender, name, dob, dod, bPics, treepos, isDead, address, phone_mobile, phone_res, phone_off, father_root, updated',
                        'safe',
                        'on' => 'search'
                )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array (
                'eventdates' => array (
                        self::HAS_MANY,
                        'Eventdates',
                        'cid'
                ),
                'marriages1' => array (
                        self::HAS_MANY,
                        'Marriage',
                        'husband_cid'
                ),
                'marriages2' => array (
                        self::HAS_MANY,
                        'Marriage',
                        'wife_cid'
                ),
                'husbands' => array (
                        self::MANY_MANY,
                        'Person',
                        'marriages(wife_cid,husband_cid)'
                ),
                'wives' => array (
                        self::MANY_MANY,
                        'Person',
                        'marriages(husband_cid,wife_cid)'
                ),
                'father' => array (
                        self::BELONGS_TO,
                        'Person',
                        'father_cid'
                ),
                'children1' => array (
                        self::HAS_MANY,
                        'Person',
                        'father_cid',
                        'order' => 'dob,cid',
                ),
                'mother' => array (
                        self::BELONGS_TO,
                        'Person',
                        'mother_cid'
                ),
                'children2' => array (
                        self::HAS_MANY,
                        'Person',
                        'mother_cid',
                        'order' => 'dob,cid',
                ),
                'pics' => array (
                        self::HAS_MANY,
                        'Pics',
                        'cid'
                )
        );
    }

    function cmp($a, $b)
    {
        $at = strtotime($a->dob);
        $bt = strtotime($b->dob);
        if ($at == $bt)
        {
            return 0;
        }
        return ($at >  $bt ? 1 : - 1);
    }

    public function getchildren()
    {
        if (count ( $this->children1 ) == 0)
            $childs = $this->children2;
        else
            $childs = $this->children1;

        uasort ( $childs, [
                $this,
                'cmp'
        ] );

        return $childs;
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array (
                'cid' => 'Cid',
                'firstname' => __ ( 'Firstname' ),
                'father_cid' => __ ( 'Father' ),
                'mother_cid' => __ ( 'Mother' ),
                'created' => __ ( 'Created' ),
                'deleted' => __ ( 'Deleted' ),
                'lastname' => __ ( 'Lastname' ),
                'gender' => __ ( 'Gender' ),
                'name' => __ ( 'Name' ),
                'dob' => __ ( 'Dob' ),
                'dod' => __ ( 'Dod' ),
                'bPics' => __ ( 'B Pics' ),
                'treepos' => __ ( 'Treepos' ),
                'isDead' => __ ( 'Is Dead' ),
                'address' => __ ( 'Address' ),
                'phone_mobile' => __ ( 'Phone Mobile' ),
                'phone_res' => __ ( 'Phone Res' ),
                'phone_off' => __ ( 'Phone Off' ),
                'father_root' => __ ( 'Father Root' ),
                'updated' => __ ( 'Updated' ),
                'spouse' => __ ( 'Spouse' )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will
     * filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     *         based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria ();

        $criteria->compare ( 'cid', $this->cid );
        $criteria->compare ( 'firstname', $this->firstname, true );
        $criteria->compare ( 'father_cid', $this->father_cid );
        $criteria->compare ( 'mother_cid', $this->mother_cid );
        $criteria->compare ( 'created', $this->created, true );
        $criteria->compare ( 'deleted', $this->deleted );
        $criteria->compare ( 'lastname', $this->lastname, true );
        $criteria->compare ( 'gender', $this->gender );
        $criteria->compare ( 'name', $this->name, true );
        $criteria->compare ( 'dob', $this->dob, true );
        $criteria->compare ( 'dod', $this->dod, true );
        $criteria->compare ( 'bPics', $this->bPics );
        $criteria->compare ( 'treepos', $this->treepos, true );
        $criteria->compare ( 'isDead', $this->isDead );
        $criteria->compare ( 'address', $this->address, true );
        $criteria->compare ( 'phone_mobile', $this->phone_mobile, true );
        $criteria->compare ( 'phone_res', $this->phone_res, true );
        $criteria->compare ( 'phone_off', $this->phone_off, true );
        $criteria->compare ( 'father_root', $this->father_root, true );
        $criteria->compare ( 'updated', $this->updated, true );
        $criteria->compare ( 'owner_gid', $this->owner_gid, true );

        return new CActiveDataProvider ( $this, array (
                'criteria' => $criteria
        ) );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your
     * CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return Person the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model ( $className );
    }

    /**
     * #20170803:vikas:ggn:added nice age to namelink
     */
    public function getniceage()
    {
        $datetime1 = new DateTime ( $this->dob );
        $datetime2 = new DateTime (empty($this->dod) ? 'now' : $this->dod);
        $interval = $datetime1->diff ( $datetime2 );

        $age = $interval->format ( '%y' );
        if($age==0)
        {
            return $interval->format ( '%m m' );
        }
        else if ($age > 200)
            $age = 0;
        return $age .  ' y';
    }

    public function getage()
    {
        $datetime1 = new DateTime ( $this->dob );
        $datetime2 = new DateTime (empty($this->dod) ? 'now' : $this->dod);
        $interval = $datetime1->diff ( $datetime2 );
        $age = $interval->format ( '%y' );
        if ($age > 200)
            $age = 0;


        return $age;
    }

    /**
     * Moved from clsPerson
     * 201707092128:vikas:Gurgaon
     */
    function getArray()
    {
        $arr = array ();
        $carr = array ();

        $name1 = trim ( $this->firstname . " " . $this->lastname ) . " ";
        $sc = strpos ( $name1, " " );
        // print "sc=$sc, [$name1] ";
        $name1 = substr ( $name1, 0, $sc );
        // print ", result=[$name1]\n";
        if ($name1 == "NoName")
            $name1 = "?";
        $arr ['name'] = $name1;

        $md = 0;

        $children = Person::model ()->findAll (
                [
                        'condition' => ':cid in (father_cid,mother_cid)',
                        'params' => [
                                ':cid' => $this->cid
                        ],
                        'select' => 'firstname,lastname,cid'
                ] );
        // $sql = "select cid from persons where {$this->id} in
        // (father_cid,mother_cid)";
        // $r = doquery($sql);
        foreach ( $children as $child )
        {
            $carr [] = $child->getArray ();
            $md = $md < $child_array ['depth'] ? $child_array ['depth'] : $md;
        }
        $arr ['children'] = $carr;
        $arr ['depth'] = 1 + $md;
        return $arr;
    }

    public function getD3marriages($depth = 1)
    {
        $data = [ ];
        $data ['name'] = $this->name . " " . $this->age . "y";
        #http://gene.local/index.php/chart/d3/253?c=0
        $data ["class"] = $this->gender ? 'man' : 'woman';
        $data ["class"] += " " + empty($this->dod) ? 'dead' : 'dead';
        $data ["class"] += " " + count($this->spouses)>0 ? 'married' : 'single';
        $data ["class"] += " " + $this->age >0 ? 'dob' : 'nodob';


        $data ["textClass"] = "nodeText";
        $data ["depthOffset"] = $depth;
        if (count ( $this->spouses ))
        {
            foreach ( $this->spouses as $spouse )
            {
                $marriage = [ ];
                $marriage ['spouse'] = [
                        'name' => $spouse->name,
                        'class' => $spouse->gender ? 'man' : 'woman'
                ];
                $children = Person::model ()->findAll (
                        [
                                'condition' => 'father_cid in (:id1,:id2) and mother_cid in (:id1,:id2)',
                                'params' => [
                                        'id1' => $this->cid,
                                        'id2' => $spouse->cid
                                ]
                        ] );
                foreach ( $children as $child )
                {
                    $marriage ['children'] [] = $child->getD3 ( $depth + 1 );
                }
            }
            $data ['marriages'] [] = $marriage;
        }
        $data ['extra'] = "";
        return $data;
        /*
         * $data['marriages'] = $marriages;
         * marriages: [{ // Marriages is a list of nodes
         * spouse: { // Each marriage has one spouse
         * name: "Mother",
         * },
         * children: [{ // List of children nodes
         * name: "Child",
         * }]
         * }],
         * extra: {}
         */
    }

    /**
     * This method generates the structure that directly feeds into D3 charts
     *
     * @return array Array which is later converted to JSON
     */
    public function getD3hierarchy($level = 0)
    {
        if (self::$maxlevels < $level)
            self::$maxlevels = $level;

        $data = [ ];
        $data ['name'] = trim ( $this->name . " " . $this->age . "y" );

        $data ["class"] = implode(' ',[ $this->gender ? 'man' : 'woman',
        empty($this->dod) ? '' : 'dead',
        count($this->spouses)>0 ? 'married' : 'single',
        $this->age >0 ? 'dob' : 'nodob']);

        if (count ( $this->children ))
        {
            foreach ( $this->children as $child )
            {
                $data ['children'] [] = $child->getD3hierarchy ( $level + 1 );
            }
        }
        return $data;
    }

    public function getgrandchildren()
    {
        $gchild = [ ];
        foreach ( $this->children as $child )
        {
            $gchild = array_merge ( $gchild, $child->children );
        }

        uasort ( $gchild, [
                $this,
                'cmp'
        ] );
        return $gchild;
    }

    public function getgreatgrandchildren()
    {
        $gchild = [ ];
        foreach ( $this->grandchildren as $child )
        {
            $gchild = array_merge ( $gchild, $child->children );
        }

        uasort ( $gchild, [
                $this,
                'cmp'
        ] );
        return $gchild;
    }

    public function getgrandfather()
    {
        if (isset ( $this->father->father ))
            return $this->father->father;
    }

    public function getid_person()
    {
        return $this->cid;
    }

    public function getAudit()
    {
        $notes = [];
        if (empty ( $this->dob ))
            $notes [] = 'DOB' ;
        if (! isset ( $this->father ))
            $notes [] =  'Father' ;
        if (! isset ( $this->mother ))
            $notes [] =  'Mother' ;
        if($this->age>30)
        {
            $spoues = $this->spouses;
            if(count($spoues)==0)
                $notes[] = 'Spouse';
        }
        $marriages = $this->marriages;
        foreach($marriages as $marriage)
        {
            if(empty($marriage->dom))
            {
                $notes[] = 'DOM';
                break;
            }
        }
        $children = $this->children;
        if(count($children)==0)
        {
            if($this->age>0 && $this->age<25);
            else
                $notes[] = 'Children';
        }
        return $notes;
    }

}
