<?php
/*
* 直播模型
*/
class LiveLogs extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{live_logs}}";
	}

	public function getLtime($where){
		$sql = "SELECT SUM(seconds) as time FROM {{live_logs}} WHERE ".$where;
		$result = yii::app()->db->createCommand($sql)->queryRow();
		return !empty($result['time']) ? $result['time'] : 0;

	}
    
}
?>