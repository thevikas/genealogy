<?php

/**
 * This is the model class for table "gene.mru".
 *
 * The followings are the available columns in table 'gene.mru':
 * @property integer $cid
 * @property string $dated
 */
class RecentPerson extends CActiveRecord
{
    
    public function behaviors()
    {
        return array (
                'CTimestampBehavior' => array (
                        'class' => 'zii.behaviors.CTimestampBehavior',
                        'createAttribute' => 'dated',
                        'updateAttribute' => null,
                ),
                'NameLinkBehavior' => array (
                        'class' => 'application.behaviours.NameLinkBehavior',
                        'controller' => 'person',
                ),
        );
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mru';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid', 'required'),
			array('cid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cid, dated', 'safe', 'on'=>'search'),
		);
	}
	
	public static function add($id)
	{
	    RecentPerson::model()->deleteAllByAttributes(['cid' => $id]);
	    $rp = new RecentPerson();
	    $rp->cid = $id;
	    $rp->save();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
	        'person' => array(self::BELONGS_TO, 'Person', 'cid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cid' => 'Cid',
			'dated' => 'Dated',
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
		$criteria->compare('dated',$this->dated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecentPerson the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
