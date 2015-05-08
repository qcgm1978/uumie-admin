<?php
/*
*系统设置模型
*/
class Config extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{config}}";
	}
	public function getScale($value){

		$criteria = new CDbCriteria;
	    $criteria->select = 'value';
	    $criteria->condition='code=:code';
		$criteria->params=array(':code'=>$value);
	      
	    $result = $this->find($criteria);
	    
	    return !empty($result) ? $result['value'] :'';
	}
	

	
    
}
?>