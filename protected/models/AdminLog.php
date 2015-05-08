<?php
/*
* 日志模型
*/
class AdminLog extends CActiveRecord{

	/*
	*返回模型
	*/

	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{admin_log}}";
	}
	public function adminLogs($logInfo){

		$adminLog = new AdminLog();
		$adminLog->log_time = time();
		$adminLog->uid = User::model()->getSuid($_SESSION['admin__name']);
		$adminLog->log_info = stripslashes($logInfo);
		$adminLog->ip_address = userRealIp();
		return $adminLog->save() ? true :false;

	}
    
}
?>