<?php
/*
*七位号码库模型
*/
class NumberSeven extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{number_seven}}";
	}
	
    
}
?>