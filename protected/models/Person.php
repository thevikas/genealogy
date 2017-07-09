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
 */
class Person extends CActiveRecord
{
    
    public function behaviors()
    {
        return array (
                'NameLinkBehavior' => array (
                        'class' => 'application.behaviours.NameLinkBehavior',
                        'controller' => 'person',
                        'template' => '{link} {age}yrs',
                        'callback' => function($str,$model)
                        {
                            $spouses = array_merge($model->husbands,$model->wives );
                            if(count($spouses)==1)
                                return $str . ' ' . CHtml::image('/imgs/marriage.gif') . ' ' . $spouses[0]->getnamelink(['nocallback'=>1]);
                            return $str;
                        }
                ),                
        );
    }
    
    public function beforeSave()
    {
        $this->name = $this->firstname . ' ' . $this->lastname;
        
        $this->dob = empty($this->dob) ? null : $this->dob;
        $this->dod = empty($this->dod) ? null : $this->dod;
        
        return parent::beforeSave();
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persons';
	}	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('father_cid, mother_cid, deleted, gender, bPics, isDead', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname, name', 'length', 'max'=>255),
			array('treepos, father_root', 'length', 'max'=>10),
			array('address', 'length', 'max'=>250),
			array('phone_mobile, phone_res, phone_off', 'length', 'max'=>20),
			array('created, dob, dod', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cid, firstname, father_cid, mother_cid, created, deleted, lastname, gender, name, dob, dod, bPics, treepos, isDead, address, phone_mobile, phone_res, phone_off, father_root, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'eventdates' => array(self::HAS_MANY, 'Eventdates', 'cid'),
			'marriages1' => array(self::HAS_MANY, 'Marriage', 'husband_cid'),
			'marriages2' => array(self::HAS_MANY, 'Marriage', 'wife_cid'),
	        'husbands' => array (
	                self::MANY_MANY,
	                'Person',
	                'marriages(wife_cid,husband_cid)',		                
	        ),
	        'wives' => array (
	                self::MANY_MANY,
	                'Person',
	                'marriages(husband_cid,wife_cid)',
	        ),		        
			'father' => array(self::BELONGS_TO, 'Person', 'father_cid'),
			'children1' => array(self::HAS_MANY, 'Person', 'father_cid'),
			'mother' => array(self::BELONGS_TO, 'Person', 'mother_cid'),
			'children2' => array(self::HAS_MANY, 'Person', 'mother_cid'),
			'pics' => array(self::HAS_MANY, 'Pics', 'cid'),
		);
	}
	
	public function getchildren()
	{
	    if(count($this->children1) == 0)
	        return $this->children2;
        return $this->children1;
	}

	/**
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
                'updated' => __ ( 'Updated' ) ,
                'spouse' => __('Spouse'),
        );
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('cid',$this->cid);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('father_cid',$this->father_cid);
		$criteria->compare('mother_cid',$this->mother_cid);
		$criteria->compare('dated',$this->dated,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('dod',$this->dod,true);
		$criteria->compare('bPics',$this->bPics);
		$criteria->compare('treepos',$this->treepos,true);
		$criteria->compare('isDead',$this->isDead);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone_mobile',$this->phone_mobile,true);
		$criteria->compare('phone_res',$this->phone_res,true);
		$criteria->compare('phone_off',$this->phone_off,true);
		$criteria->compare('father_root',$this->father_root,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Person the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getage()
	{
	    $datetime1 = new DateTime($this->dob);
	    $datetime2 = new DateTime();
	    $interval = $datetime1->diff($datetime2);
	    $age = $interval->format('%Y');
	    if($age > 200)
	        $age = 0;
	    return $age;
	}
}
