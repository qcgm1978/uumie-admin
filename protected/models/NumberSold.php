<?php
/*
*后台已售号码模型
*/
class NumberSold extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{number_sold}}";
	}
	
    
}
?>