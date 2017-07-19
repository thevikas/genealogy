<?php

/**
 * This is the model class for table "marriage_rep1".
 *
 * The followings are the available columns in table 'marriage_rep1':
 * @property integer $hcid
 * @property integer $wcid
 * @property string $dom
 * @property string $h_dob
 * @property string $w_dob
 * @property string $h_mage
 * @property string $w_mage
 */
class MarriageReport1 extends CActiveRecord
{

    public function primaryKey()
    {
        return 'mid';
        // For composite primary key, return an array like the following
        // return array('pk1', 'pk2');
    }

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'marriage_rep1';
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
                        'hcid, wcid',
                        'numerical',
                        'integerOnly' => true 
                ),
                array (
                        'h_mage, w_mage',
                        'length',
                        'max' => 16 
                ),
                array (
                        'dom, h_dob, w_dob',
                        'safe' 
                ),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be
                // searched.
                array (
                        'hcid, wcid, dom, h_dob, w_dob, h_mage, w_mage',
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
                'husband' => array (
                        self::BELONGS_TO,
                        'Person',
                        'hcid' 
                ),
                'wife' => array (
                        self::BELONGS_TO,
                        'Person',
                        'wcid' 
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
                'hcid' => 'Hcid',
                'wcid' => 'Wcid',
                'dom' => 'Dom',
                'h_dob' => 'H Dob',
                'w_dob' => 'W Dob',
                'h_mage' => 'H Mage',
                'w_mage' => 'W Mage' 
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
        
        $criteria->order = 'mid desc';
        
        $criteria->compare ( 'hcid', $this->hcid );
        $criteria->compare ( 'wcid', $this->wcid );
        $criteria->compare ( 'dom', $this->dom, true );
        $criteria->compare ( 'h_dob', $this->h_dob, true );
        $criteria->compare ( 'w_dob', $this->w_dob, true );
        $criteria->compare ( 'h_mage', $this->h_mage, true );
        $criteria->compare ( 'w_mage', $this->w_mage, true );
        
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
     * @return MarriageReport1 the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model ( $className );
    }
}
