<?php
/*
* 房间扩展
*/
class RoomFields extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{room_fields}}";
	}
	public function getRoomFieldsInfo($roomid){
    	$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition = "room_id = '".$roomid."'";
	    $result = $this->find($criteria);
	      
	    return  !empty($result) ? $result :0;
    }
	
    
}
?>