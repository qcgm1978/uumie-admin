<?php
/*
* 礼物记录模型
*/
class GiftLogs extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{gift_logs}}";
	}
	public function getTprice($where){
		$sql = "SELECT SUM(total_price) as tprice FROM {{gift_logs}} WHERE ".$where;
		$result = yii::app()->db->createCommand($sql)->queryRow();
		return !empty($result['tprice']) ? $result['tprice'] : 0;

	}
	
    
}
?>