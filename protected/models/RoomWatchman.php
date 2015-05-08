<?php
/*
*后台巡管模型
*/
class RoomWatchman extends CActiveRecord{

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
		return "{{room_watchman}}";
	}
    
    public function attributeLabels() {
        return array(
            'username' =>'用户帐号'
        );
    }
}
?>