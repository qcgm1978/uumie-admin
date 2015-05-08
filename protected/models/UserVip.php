<?php
/*
*VIP 模型
*/
class UserVip extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{user_vip}}";
	}

	 /**
     * 判断用户是否是VIP
     *
     * @param int $uid
     * @return 1:vip  0:不是vip
     */
    public function isVip($uid){

      $criteria = new CDbCriteria;
      $criteria->select = 'vip_id';
      $criteria->condition='uid=:uid AND expire_time>=:expiretime';
	  $criteria->params=array(':uid'=>$uid,':expiretime'=>time());
      
      $result = $this->find($criteria);
      return  !empty($result) ? intval($result['vip_id']):0;
    }

    /* 添加爵位等级 */
	public function addVip($uid, $vip_id, $add_coin = true) {
		// 获取爵位道具信息
		$vipInfo =Magic::model()->getMagicInfo($vip_id);
	
		// 获取用户现在VIPinfo
		$criteria = new CDbCriteria;
      	$criteria->select = '*';
     	$criteria->condition='uid=:uid';
	 	$criteria->params=array(':uid'=>$uid);
	 	
	 	$userVip = $this->find($criteria);

	 	if ($userVip['expire_time'] < time()) {
	 		$time = time() + 3600 * 24 * 30;
	 	}else{
	 		$time = $userVip['expire_time'] + 3600 * 24 * 30;
	 	}
	 	$nickname = User::model()->getUserNick($uid);
	 	$gid = User::model()->getUserNicegid($uid);
	 	$msg = ($add_coin != true) ? '[只加等级]' : '[完全使用]';
	 	
	 	if (!empty($userVip)) {
	 		
	 		$res = 0;
	 		// 用户级别大于，直接返回
			if($userVip['vip_id'] > $vip_id && (($userVip['vip_id'] < 100 && $vip_id < 100) || ($userVip['vip_id'] >= 100 && $vip_id >= 100))){
	 			$res = 0;
	 		}
	 		// 用户级别相等, 则表示续费
	 		if ($userVip['vip_id'] = $vip_id) {
	 			UserVip::model()->updateByPk($uid,array('expire_time'=>$time));
	 			$res = 11;
	 			//log日志
	 		}
	 		// 用户级别小于，则表示升级
	 		if(($userVip['vip_id'] < $vip_id && (($userVip['vip_id'] < 100 && $vip_id < 100) || ($userVip['vip_id'] >= 100 && $vip_id >= 100))) || ($userVip['vip_id'] > $vip_id && (($userVip['vip_id'] < 100 && $vip_id >= 100) || ($userVip['vip_id'] >= 100 && $vip_id < 100)))){
	 			UserVip::model()->updateByPk($uid,array('expire_time'=>$time,'vip_id'=>$vip_id));
				$res = 12;
				//log日志
			}

	 	}else{

	 		$uservip = new UserVip();
	 		$uservip->uid = $uid;
	 		$uservip->vip_id = $vip_id;
	 		$uservip->type = 2;
	 		$uservip->start_time = time();
	 		$uservip->expire_time = $time;
	 		if ($uservip->save()) {
	 			$res = 1;
	 		}
	 		
	 	}

	    if ($add_coin) {
	    	UserAccount::model()->changeCoin($uid, $vipInfo['add_coin']);
	    }
	    return !empty($res) ? $res : 0;
	}


    
}
?>