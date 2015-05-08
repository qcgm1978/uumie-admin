<?php
/*
* 充值记录模型
*/
class PayLogs extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{pay_logs}}";
	}
	public function getSamount($uid){
		$time = time() - 3600 * 24 * 30;
		$sql = "SELECT SUM(amount) as samount FROM {{pay_logs}} WHERE uid='".$uid."'  AND is_pay=1 AND is_addcoin=1 AND add_time > '$time'";
		$result = yii::app()->db->createCommand($sql)->queryRow();
		return !empty($result['samount']) ? $result['samount'] : 0;
	}
	/**
	 * 虚拟充值记录
	 *
	 * @param int $uid
	 * @param string $username
	 * @param int $addcoin
	 * @return order_sn
	 */
	public function addVirtualPayLog($uid, $fromuid, $payname, $addcoin = 0, $amount = 0, $operateuid = 0) {
		// 生成虚拟订单号
		$payLogs = new PayLogs();
		$payLogs->order_sn = getOrderSn();
		$payLogs->uid = $uid;
		$payLogs->pay_name = $payname; 
		$payLogs->from_uid = $fromuid;
		$payLogs->amount = $amount;
		$payLogs->addcoin = $addcoin; 
		$payLogs->is_pay = 1; 
		$payLogs->is_addcoin = 1;
		$payLogs->add_time = time();
		$payLogs->op_uid = $operateuid;
		return $payLogs->save() ? true :false;
	}
	//订单信息
	public function getSscPay(){
		$sql = "SELECT COUNT(*) as sscpay FROM {{pay_logs}} WHERE is_pay='1' AND is_addcoin='1'";
		$result = yii::app()->db->createCommand($sql)->queryRow();
    	return !empty($result) ? $result['sscpay'] : 0;
	}
	//无效订单
	public function getInvPay(){
		$invtime = time()-3600 * 72;
		$sql = "SELECT COUNT(*) as invpay FROM {{pay_logs}} WHERE is_pay='0' AND is_addcoin='0' AND log_time < $invtime";
		$result = yii::app()->db->createCommand($sql)->queryRow();
    	return !empty($result) ? $result['invpay'] : 0;

	}
	
    
}
?>