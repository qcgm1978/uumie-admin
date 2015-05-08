<?php
/*
*后台在售号码模型
*/
class NumberSale extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{number_sale}}";
	}
	
    
}
?>