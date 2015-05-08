<?php
/*
* 用户统计
*/
class UserAccount extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{user_account}}";
	}

	/**
     * 账户积分变动
     *
     * @param int    $uid
     * @param int    $integral
     * @param string $change_desc
     */
    public function changeIntegral($uid, $integral){

        return $this->_changeAccount($uid, 0, 0, 0, $integral, 0, 0) ? true : false;
    }

	/**
     * 账户金币变动
     */
    public function changeCoin($uid, $coin){

        return $this->_changeAccount($uid, 0, $coin, 0, 0, 0, 0) ? true : false;
    }

	/**
     * 检查用户的金币余额
     */
	
	public function checkCoin($uid){

		$res = $this->_checkAccount($uid);

		return $this->_numFormat($res['coin']);
	}
  /**
     * 账户豆豆变动
     *
     * @param int    $uid
     * @param int    $bean
     * @param string $change_desc
     */
    public function changeBean($uid, $bean){
      
        return $this->changeAccount($uid, 0, 0, $bean, 0, 0, 0) ? true : false;
    }

	 /**
     * 检查用户的积分余额

     */
	public function checkIntegral($uid){

		$res = $this->_checkAccount($uid);

		return $this->_numFormat($res['integral']);
	}

  /* 累积充值RMB */
    public function payPoint($uid , $point){

        $sql = "UPDATE {{user_account}} SET pay_point = pay_point + ('$point')" . " WHERE uid = '$uid'";
       
        return Yii::app()->db->createCommand($sql)->execute() ? true :false;
    }

	/**
     * 检查用户的账户情况
     */

	private function _checkAccount($uid){

	    $criteria = new CDbCriteria;
      $criteria->select = '*';
      $criteria->condition = "uid = '".$uid."'";

      return $this->find($criteria);

	}
	 /**
     * 格式化金币
     * @return int
     */
    private function _numFormat($glod){

        // 舍去法取整
        return floor($glod);
    }
    
    /**
     * 更新用户账户
     * @param int     $uid
     * @param decimal $money          // 现金账户
     * @param int     $coin           // 金币，充值获得
     * @param int     $bean           // 豆豆，收到礼物获得
     * @param int     $integral       // 积分，账户充值获得
     * @param int     $income_point   // 收入点数，累计收到的豆豆
     * @param int     $expense_point  // 支出点数，累计支出的金币
     */
    private function _changeAccount($uid, $money=0, $coin=0, $bean=0, $integral=0, $income_point=0, $expense_point=0){
       
       $userAccount = new UserAccount();

       // 判断用户是否开户，如果没有则自动开户
       
       if (!$this->_checkAccount($uid)) {
       		$userAccount->uid = $uid;
       		$userAccount->save();
       }

       $userInfo = $this->_checkAccount($uid);
      
       $info = array(
            'money'=> $userInfo['money'] + $money,
            'coin'=> $userInfo['coin'] + $coin,
            'bean'=> $userInfo['bean'] + $bean,
            'integral'=> $userInfo['integral'] + $integral,
            'income_point'=> $userInfo['income_point'] + $income_point,
            'expense_point'=> $userInfo['expense_point'] + $expense_point,
        ); 

       return UserAccount::model()->updateByPk($uid, $info) ? true :false;
    }

     /**
     * 分配号码
     * @param int $gid $gid_length $sale_type $sale_point $uid
     * 
     */

    public function giveGid($gid, $gid_length, $sale_type, $sale_point, $uid){

    	// 将此号码从出售列表中删除
    	NumberSale::model()->deleteByPk($gid);
    	
    	// 分配号码
    	$numberSold = new NumberSold();
    	$numberSold->gid = $gid;
    	$numberSold->gid_length = $gid_length;
    	$numberSold->sale_type = $sale_type;
    	$numberSold->sale_point = $sale_point;
    	$numberSold->uid = $uid;
    	$numberSold->sale_time = time();

    	return $numberSold->save() ? true :false;
    	
    }
    /**
	 * 使用靓号
	 *
	 * @param int $gid
	 * @param int $uid
	 * @return 使用成功返回true 否则返回false
	 */
  	public function useGid($gid, $uid)
  	{
  		// 获取当前正在使用靓号
  		$user = User::model()->find(array(
			  'select' =>array('gid'),
			  'condition' => 'uid='."'".$uid."'",
			));
  		
  		// 如果当前正在使用的靓号和准备更换的号码相同，则直接返回使用成功
  		if ($user['uid'] == $gid)
  		{
  			return true;
  		}
  		
  		// 如果有靓号将此号码状态更新为未使用
  		if ($user['uid'])
  		{
  			NumberSold::model()->updateByPk($user['uid'],array('is_useing'=>0));
  		}
		// 将当前准备使用的号码状态更新为已使用
		if (NumberSold::model()->updateByPk($gid,array('is_useing'=>1))) {
			
  			return  User::model()->updateByPk($uid,array('gid'=>$gid)) ? true : false;  
		}
  		
  		return false;
  	} 
  /* 充值计算vip等级*/
  public function operateVipLevel($uid,$money) {
    if(!$uid){
      return 0;
    }
    //查看会员是否是vip
    $vipId = UserVip::model()->isVip($uid);
        if(!$vipId){
          //如果不是vip并且是充值只计算自然月充值，忽略消费
          //$stime = strtotime(date('Y-m-d', time())) - (date('j', time())-1) * 3600 * 24;
          
          $sumconsume = intval(PayLogs::model()->getSamount($uid));
          //取出等级
          $vipId = intval(Vip::model()->getVipId($sumconsume,$money));
          if($vipId){
            $userVip = new UserVip();
            $userVip->uid = $uid;
            $userVip->vipId = $vipId;
            $userVip->type = 0;
            $userVip->start_time = time();
            $userVip->expire_time = time()+3600*24*30;
            if($vipId < 100){//如果是爵位会员多加30天
               $userVip->expire_time = time()+3600*24*60;
            }
            //添加爵位
            $userVip->save();
           
          }
        }else{
          if($vipId >= 100){
           
            $sumconsume = intval(PayLogs::model()->getSamount($uid));
            //取出等级
            $newVipId = intval(Vip::model()->getVipId($sumconsume,$money));
            if($newVipId && ($newVipId > $vipId || $newVipId < 100)){
              $userVip = new UserVip();
              $userVip->uid = $uid;
              $userVip->vipId = $newVipId;
              $userVip->type = 0;
              $userVip->start_time = time();
              $userVip->expire_time = time()+3600*24*30;
              if($newVipId < 100){//如果是爵位会员多加30天
                $userVip->expire_time = time()+3600*24*60;
              }
              //添加爵位
              UserVip::model()->deleteByPk($uid);
              $userVip->save();
            }
          }
        }
  }  

}
?>