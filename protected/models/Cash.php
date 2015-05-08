<?php
/*
* 兑点模型
*/
class Cash extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{cash}}";
	}
	
    
}
?>