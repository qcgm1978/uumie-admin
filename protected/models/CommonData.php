<?php
/*
* 模型
*/
class CommonData extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{common_data}}";
	}
	
	public function getWordBanned($var){
		$criteria = new CDbCriteria;
      	$criteria->select = 'data';
     	$criteria->condition='var=:var';
	 	$criteria->params=array(':var'=>$var);
	 	$result = $this->find($criteria);
	 	return !empty($result) ? $result['data'] :'';
	}
    
}
?>