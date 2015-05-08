<?php
/*
*VIP 模型
*/
class UserVipVip extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{user_vip_vip}}";
	}

	 /**
     * 判断用户是否是VIP2
     *
     * @param int $uid
     * @return 1:vip  0:不是vip
     */
    public function isVip2($uid){

      $criteria = new CDbCriteria;
      $criteria->select = 'vip_id';
      $criteria->condition='uid=:uid AND expire_time>=:expiretime';
	  $criteria->params=array(':uid'=>$uid,':expiretime'=>time());
      
      $result = $this->find($criteria);
      return  !empty($result) ? intval($result['vip_id']):0;
    }
    /* 添加vip等级 */
	function addVip($uid, $vip_id,$from_uid, $add_coin = true){

		// 获取爵位道具信息
		$vip_info = VipVip::model()->getTitleInfo($vip_id);
		// 获取用户现在VIPinfo
		$user_vip = $this->getVipInfo($uid);
				
		// 计算到期时间
		if($user_vip['expire_time'] < time()){
			$time = time() + $vip_info;
		}else{
			$time = $user_vip['expire_time'] + $vip_info;
		}
		
		$nickname = User::model()->getUserNick($uid);
		$gid = User::model()->getUserNicegid($uid);
		
		
		$from_nickname = User::model()->getUserNick($from_uid);
		$gid = User::model()->getUserNicegid($uid);
		$from_gid = User::model()->getUserNicegid($from_uid);
		
		if(!$user_vip){
			$userVipVip = new UserVipVip();
			$userVipVip->uid = $uid;
			$userVipVip->vip_id = $vip_id;
			$userVipVip->type = 1;
			$userVipVip->start_time = time();
			$userVipVip->expire_time = $time;
			$userVipVip->from_uid = $from_uid;
			if ($userVipVip->save()) {
				AdminLog::model()->adminLogs("$from_nickname($from_gid)赠送VIP 给用户：$nickname($gid)");
				return 1;
			}
		}else if($user_vip['expire_time'] < time()){
			$data['expire_time'] = $time;
			$data['from_uid'] = $from_uid;

			if (UserVipVip::model()->updateByPk($uid,$data)) {
				AdminLog::model()->adminLogs("$from_nickname($from_gid)赠送VIP 给用户：$nickname($gid)");
				return 1;
			}
		}else{
			return 0;
		}
	}
	// 获取用户现在VIPinfo
    public function getVipInfo($uid){

    	$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition = "uid = '".$uid."'";
	    $result = $this->find($criteria);
      
      return  !empty($result) ?  $result:'';
    }
}
?>