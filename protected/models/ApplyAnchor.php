<?php
/*
* 主播申请模型
*/
class ApplyAnchor extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{apply_anchor}}";
	}
	
    
}
?>