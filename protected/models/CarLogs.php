<?php
/*
* 车模型
*/
class CarLogs extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{car_logs}}";
	}
	
    
}
?>