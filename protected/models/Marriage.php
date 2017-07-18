<?php

/**
 * This is the model class for table "gene.marriages".
 *
 * The followings are the available columns in table 'gene.marriages':
 * @property integer $husband_cid
 * @property integer $wife_cid
 * @property string $created
 * @property integer $mid
 * @property string $comments
 * @property string $dom
 * @property integer $owner_gid
 *
 * The followings are the available model relations:
 * @property Persons $husbandC
 * @property Persons $wifeC
 */
class Marriage extends CActiveRecord
{

    public function behaviors()
    {
        return array (
                'GroupCheckAccessBehavior' => [ 
                        'class' => 'GroupCheckAccessBehavior' 
                ],
                'CTimestampBehavior' => array (
                        'class' => 'zii.behaviors.CTimestampBehavior',
                        'createAttribute' => 'created',
                        'updateAttribute' => null 
                ),
                'NameLinkBehavior' => array (
                        'class' => 'application.behaviours.NameLinkBehavior',
                        'controller' => 'marriage' 
                ) 
        );
    }

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'marriages';
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
                        'husband_cid, wife_cid',
                        'required' 
                ),
                array (
                        'husband_cid, wife_cid',
                        'numerical',
                        'integerOnly' => true 
                ),
                array (
                        'comments',
                        'length',
                        'max' => 255 
                ),
                array (
                        'dom',
                        'safe' 
                ),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be
                // searched.
                array (
                        'husband_cid, wife_cid, created, mid, comments, dom',
                        'safe',
                        'on' => 'search' 
                ) 
        );
    }

    public function beforeSave()
    {
        $this->dom = empty ( $this->dom ) ? null : $this->dom;
        return parent::beforeSave ();
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
                'husband' => array (
                        self::BELONGS_TO,
                        'Person',
                        'husband_cid' 
                ),
                'wife' => array (
                        self::BELONGS_TO,
                        'Person',
                        'wife_cid' 
                ) 
        );
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array (
                'husband_cid' => __ ( 'Husband Cid' ),
                'wife_cid' => __ ( 'Wife Cid' ),
                'created' => __ ( 'created' ),
                'mid' => __ ( 'Mid' ),
                'comments' => __ ( 'Comments' ),
                'dom' => __ ( 'Date of Marriage' ) 
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
        
        $criteria->compare ( 'husband_cid', $this->husband_cid );
        $criteria->compare ( 'wife_cid', $this->wife_cid );
        $criteria->compare ( 'created', $this->created, true );
        $criteria->compare ( 'mid', $this->mid );
        $criteria->compare ( 'comments', $this->comments, true );
        $criteria->compare ( 'dom', $this->dom, true );
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
     * @return Marriage the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model ( $className );
    }
}
