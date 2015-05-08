<?php
/*
*直播模型
*/
class RoomLive extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{room_live}}";
	}
	public function checkRoomLive($roomid){
    	$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition = "room_id = '".$roomid."'";
	    $result = $this->find($criteria);
	      
	    return  !empty($result) ? 1 :0;
    }
	
	
    
}
?>