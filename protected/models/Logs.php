<?php

/**
 * This is the model class for table "gene.logs".
 *
 * The followings are the available columns in table 'gene.logs':
 * @property integer $uid
 * @property integer $ltype
 * @property string $dated
 * @property string $param
 * @property integer $id
 */
class Logs extends CActiveRecord
{
	static $last_log_time;

	#genealogy
	#20170823:vikas:between-hyd-bangalore-in-train
	#:copied from original constants.php
	#200508030744:vikas:some log now added

	public const LOG_LOGIN = 1; #201708231351
	public const LOG_LOGOUT = 2; #201708231351

	public const LOG_NEWPERSON = 48; #200706291212
	public const LOG_RUSHHOUR = 49; #200706291212
	public const LOG_ADDSPOUSEMAN = 50;
	public const LOG_ADDSPOUSEWOMAN = 51;
	public const LOG_SETFATHER = 52;
	public const LOG_SETMOTHER = 53;
	public const LOG_ADDCHILD = 54;
	public const LOG_ADDPARENT = 55;
	public const LOG_SUMMARY = 56;
	public const LOG_EDITPERSON = 57;
	public const LOG_DELETEPERSON = 58; #200508260716
	public const LOG_SEARCH = 59; #200607081234

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, ltype', 'numerical', 'integerOnly'=>true),
			array('param', 'length', 'max'=>100),
			array('dated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, ltype, dated, param, id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'ltype' => 'Ltype',
			'dated' => 'Dated',
			'param' => 'Param',
			'id' => 'ID',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('ltype',$this->ltype);
		$criteria->compare('dated',$this->dated,true);
		$criteria->compare('param',$this->param,true);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Logs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function l($ltype,$pkval,$param = [])
	{
		//20170823:this is a tryout to set exactly same log times
		//for all sequencial log events in the database
		//train-to-cbe
		if(!isset(self::$last_log_time))
			self::$last_log_time = time();

		$l = new Logs();
		$l->ltype = $ltype;
		$l->uid = $pkval;
		$l->dated = date('Y-m-d H:i:s',self::$last_log_time);
		if(!empty($param))
			$l->param = serialize($param);
		if(!$l->save())
		{
			error_log(print_r($l->errors,true));
			throw new Exception("could not save Log");
		}
	}
}
