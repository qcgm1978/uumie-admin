<?php
/*
*房间模型
*/
class RoomLimits extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{room_limits}}";
	}
	public function addRoomOwner($roomid, $uid){
		$roomLimits = new RoomLimits();
		$roomLimits->uid = $uid;
		$roomLimits->room_id = $roomid;
		$roomLimits->type = 1;
		return $roomLimits->save() ? true : false;

	}
	    /* 修改房主 */
    public function updateRoomOwner($roomid, $uid){
    	$sql ="SELECT room_id FROM {{room_limits}} WHERE room_id = '$roomid' AND type = '1'";
    	$result = yii::app()->db->createCommand($sql)->queryRow();
    	
    	if ($result['room_id']){
		$sql = "UPDATE {{room_limits}} SET uid = '$uid' WHERE room_id = '$roomid' AND type = '1'";
		Yii::app()->db->createCommand($sql)->execute();
     	}else{
     		$this->addRoomOwner($room_id, $uid);
     	}    	
    }
	
	
    
}
?>