<?php
/**
 * (Super)View Runner for Company
 * @author vikasyadav
 *
 * @property Project $majorProjects
 */
class PersonView extends Person
{
    var $cache_logourl;

    public function attributeLabels()
    {
        return array_merge ( parent::attributeLabels (), 
                [ 
                        'logo' => true,
                        'majorProjects' => true,
                        'supertitle' => true,
                        'attrs' => true 
                ] );
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
                'marriages1' => array (
                        self::HAS_MANY,
                        'MarriageView',
                        'husband_cid' 
                ),
                'marriages2' => array (
                        self::HAS_MANY,
                        'MarriageView',
                        'wife_cid' 
                ),
                'husbands' => array (
                        self::MANY_MANY,
                        'PersonView',
                        'marriages(wife_cid,husband_cid)' 
                ),
                'wives' => array (
                        self::MANY_MANY,
                        'PersonView',
                        'marriages(husband_cid,wife_cid)' 
                ),
                'father' => array (
                        self::BELONGS_TO,
                        'PersonView',
                        'father_cid' 
                ),
                'children1' => array (
                        self::HAS_MANY,
                        'PersonView',
                        'father_cid' 
                ),
                'mother' => array (
                        self::BELONGS_TO,
                        'PersonView',
                        'mother_cid' 
                ),
                'children2' => array (
                        self::HAS_MANY,
                        'PersonView',
                        'mother_cid' 
                ) 
            // 'pics' => array(self::HAS_MANY, 'Pics', 'cid'),
        );
    }

    public function getattrs($full = false)
    {
        $attrs = $this->getAttributes ( 
                [ 
                        'firstname',
                        'lastname',
                        'name',
                        'id_person',
                        'mobile',
                        'email',
                        'age' 
                ] );
        $attrs ['id_person'] = $this->cid;
        $attrs ['age'] = intval ( $this->age );
        $attrs ['gender'] = intval ( $this->gender );
        /*
         * $attrs ['languagebox'] = $this->getlanguagebox ();
         * $attrs ['intro'] = $this->intro;
         * $attrs ['htmlid'] = $this->htmlid;
         */
        if (! $full)
            return $attrs;
        
        $item = [ ];
        $item ['person'] = $attrs;
        if (isset ( $this->father ))
            $item ['father'] = $this->father->attrs;
        if (isset ( $this->mother ))
            $item ['mother'] = $this->mother->attrs;
        if (isset ( $this->spouses [0] ))
            $item ['spouse'] = $this->spouses [0]->attrs;
        $children = $this->children;
        if (count ( $children ))
        {
            $item ['child_ids'] = [ ];
            foreach ( $children as $child )
                $item ['child_ids'] [] = intval ( $child->cid );
        }
        return $item;
    }

    static function fromhtmlid($htmlid)
    {
        return $htmlid; // disabling hashing for the time
    }
}
