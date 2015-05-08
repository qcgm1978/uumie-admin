<?php
/*
*后台虚拟人模型
*/
class UserVirtual extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){
		return parent::model($className);
	}
	/*
	*返回表名
	*/
	public function tableName(){
		
		return "{{user_virtual}}";

	}
    
}
?>