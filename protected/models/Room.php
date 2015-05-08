<?php
/*
*房间模型
*/
class Room extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){
		return parent::model($className);
	}
	/*
	*返回表名
	*/
	public function tableName(){
		
		return "{{room}}";

	}
	/* 获取房间名称 */
    public function getRoomName($room_id){
		$criteria = new CDbCriteria;
	    $criteria->select = 'room_name';
	    $criteria->condition = "room_id = '".$room_id."'";
	    $result = $this->find($criteria);
	      
	    return  $result['room_name'];
        
    }
    public function getRoomInfo($roomid){
    	$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition = "room_id = '".$roomid."'";
	    $result = $this->find($criteria);
	      
	    return  !empty($result) ? $result :0;
    }
    public function getRoomsCount($server_id){
    	$sql = "SELECT COUNT(*) as num FROM {{room}} WHERE server_id = $server_id";
    	$result = yii::app()->db->createCommand($sql)->queryRow();
    	return !empty($result) ? $result['num'] :0;
    }
        /* 判断房间名称是否已经存在 */
    public function roomNameExists ($name, $exclude=''){
        $sql = "SELECT COUNT(*) as num FROM {{room}} WHERE room_name = '$name' AND room_name IS NOT NULL AND room_id <> '$exclude'";
        $result = yii::app()->db->createCommand($sql)->queryRow();
    	return !empty($result) ? $result['num'] :0;
    }	
    /* 获取房主账号 */
    public function getRoomOwner($roomid){
        
        $uid = $this->roomOwnerUid($roomid);
		return User::model()->getUserName($uid);
    }
        /* 获取房间所有管理员或者副房主 */
    public function getRoomManager($roomid, $type = 3){

    	$sql = "SELECT l.uid, u.username, u.gid, f.nickname FROM {{room_limits}} AS l LEFT JOIN {{user}} AS u ON (u.uid = l.uid) LEFT JOIN {{user_fields}} AS f ON (f.uid = l.uid) WHERE l.room_id='$roomid' AND l.type='$type' GROUP BY l.uid";
    	$result = yii::app()->db->createCommand($sql)->queryAll();
    	return !empty($result) ? $result : '';
    }
    /* 获取房主UID */
    public function roomOwnerUid($roomid){
		$sql = "SELECT uid FROM {{room_limits}} WHERE room_id='$roomid' AND type='1'";
        $result = yii::app()->db->createCommand($sql)->queryRow();
	    return  !empty($result) ? $result['uid'] :0;
    }


}
?>