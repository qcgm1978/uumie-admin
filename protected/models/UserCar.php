<?php
/*
*座驾模型
*/
class UserCar extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{user_car}}";
	}
	/**
	 * 取得会员座驾信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function getCarInfo($id) {
		$criteria = new CDbCriteria;
      	$criteria->select = 'id, uid, car_id, expire_time, expired, used';
     	$criteria->condition='id=:id and expired=:expired';
	 	$criteria->params=array(':id'=>$id,':expired'=>0);
	 	$carInfo = $this->find($criteria);
	 	return !empty($carInfo) ? $carInfo :'';
	}

	public function checkUserCar($car_id,$uid) {
		$criteria = new CDbCriteria;
      	$criteria->select = 'uid';
     	$criteria->condition='car_id=:car_id and uid=:uid and expired=:expired';
	 	$criteria->params=array(':car_id'=>$car_id,':uid'=>$uid,':expired'=>0);
	 	$carInfo = $this->find($criteria);
	 	
	 	return !empty($carInfo) ? $carInfo['uid'] :'';
	}
	
    
}
?>