<?php

/**
 * This is the model class for table "gene.stats".
 *
 * The followings are the available columns in table 'gene.stats':
 * @property integer $cid
 * @property integer $father_tree
 * @property integer $mother_tree
 * @property integer $father_root
 * @property integer $mother_root
 */
class Stats extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid, father_tree, mother_tree, father_root, mother_root', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cid, father_tree, mother_tree, father_root, mother_root', 'safe', 'on'=>'search'),
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
			'cid' => 'Cid',
			'father_tree' => 'Father Tree',
			'mother_tree' => 'Mother Tree',
			'father_root' => 'Father Root',
			'mother_root' => 'Mother Root',
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
		$criteria->compare('father_tree',$this->father_tree);
		$criteria->compare('mother_tree',$this->mother_tree);
		$criteria->compare('father_root',$this->father_root);
		$criteria->compare('mother_root',$this->mother_root);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Stats the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
