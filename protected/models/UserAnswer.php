<?php
/*
* 审核模型
*/
class UserAnswer extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{user_answer}}";
	}
	
    
}
?>