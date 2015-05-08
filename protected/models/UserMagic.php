<?php
/*
* 用户道具模型
*/
class UserMagic extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
	
		return "{{user_magic}}";
	}

	/* 获取道具名称 */
	public function giveVip($uid, $vip_id, $magic_sum = 1){

		$criteria = new CDbCriteria;
        $criteria->select = 'magic_id, magic_name, vip_id, time_limit, add_coin';
        $criteria->condition='vip_id=:vip_id';
        $criteria->params=array(':vip_id'=>$vip_id);
        
        $vipInfo = Magic::model()->find($criteria);

        $UserMagic = new UserMagic();
 		$UserMagic->uid = $uid;
 		$UserMagic->magic_id = $vipInfo['magic_id'];
 		$UserMagic->magic_sum = $magic_sum;
 		$UserMagic->add_coin = $vipInfo['add_coin'];
 		$UserMagic->time_limit = $vipInfo['time_limit'];

        return $UserMagic->save() ? 1 :0;

	}
	
    
}
?>