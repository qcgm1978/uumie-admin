<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
class FinanceController extends Controller{


	public function actionIndex(){

		$this->render('index');
	}

	//充值记录
	
	public function actionRecharge(){
		
		$data = array(
			'uid'=>$_GET['uid'] ? $_GET['uid'] :'',
			'url'=>$_GET['uid'] ? $this->createUrl("finance/recharge",array('uid'=>$_GET['uid'])) : $this->createUrl("finance/recharge"),
			);

		$this->render('recharge',$data);

	}

	public function actionRecAjax(){

		if (Yii::app()->request->isAjaxRequest) {
			$reconid = Yii::app()->request->getParam('reconid');	
			if ($reconid) {
				$where = " is_pay <> '1'";
			}else{

				$where = " is_pay = '1'";
			}

			
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('starttime')) {
				$where .= " and add_time >= '".strtotime(Yii::app()->request->getParam('starttime'))."'";
			}
			if (Yii::app()->request->getParam('endtime')) {
				$where .= " and add_time <= '".strtotime(Yii::app()->request->getParam('endtime'))."'";
			}
			$uid = Yii::app()->request->getParam('uid');
			
			if ($uid) {

				$where .= " AND uid = '$uid'";				
			}

			$paytype = Yii::app()->request->getParam('paytype');
			
			if ($paytype) {

				$where .= " AND pay_name = '$paytype'";				
			}
			$orderid = Yii::app()->request->getParam('orderid');
			
			if ($orderid) {

				$where .= " AND order_sn = '$orderid'";				
			}
			if (Yii::app()->request->getParam('gid')) {
				
				$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
				
				if ($uid) {

				 	$where .= " AND uid = '" . $uid . "'";
				}
			}

			
			$order = 'ORDER BY log_id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT order_sn, uid, from_uid, pay_name, amount, addcoin, magic_id, magic_sum, add_time, op_uid FROM {{pay_logs}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$rechargeInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{pay_logs}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$sqlTotal = "SELECT SUM(amount) as total_amount FROM {{pay_logs}} where ".$where;
			
			$total_amount = yii::app()->db->createCommand($sqlTotal)->queryRow();

			$sqlQuery = "SELECT SUM(amount) as query_amount FROM {{pay_logs}} where ".$where;
			
			$query_amount = yii::app()->db->createCommand($sqlQuery)->queryRow();
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			$amount_count = 0;
			
			foreach ($rechargeInfo as $k => $v) {
				
				$magicName = $v['magic_id'] ? Magic::model()->getMagicName($v['magic_id'],'magic_name') .$v['magic_sum'].'个' : '';
				$str = $reconid ? '(<a href="'.$this->createUrl("finance/recon",array('uid'=>$v['uid'])).'">'.User::model()->getUserNicegid($v['uid']).'</a>)' :'(<a href="'.$this->createUrl("finance/recharge",array('uid'=>$v['uid'])).'">'.User::model()->getUserNicegid($v['uid']).'</a>)';
				$rechargeInfo[$k]['nickname'] =  User::model()->getUserNick($v['uid']).$str;
				$rechargeInfo[$k]['from_nickname'] =  User::model()->getUserNick($v['from_uid']);
				$rechargeInfo[$k]['amount'] =  $v['amount'] ? '￥'.$v['amount'] :'####';
				$rechargeInfo[$k]['add_time'] =  date('Y-m-d H:i:s',$v['add_time']);
				$rechargeInfo[$k]['comefrom'] = User::model()->getFieldsName('comefrom',$v['uid']);
				$rechargeInfo[$k]['op_nickname'] =  User::model()->getUserNick($v['op_uid']);
				$conin = $v['addcoin'] ? 'U币 '.$v['addcoin'].'个':0;
				$rechargeInfo[$k]['addcoin'] = $conin ? $conin :$magicName;
				$amount_count  += $v['amount'];
			}

			if($page > $pageCount) $page = $pageCount;
			$data=array(
				'page'=>$page,
				'pageCount'=>$pageCount,
				'amount_count'=>$amount_count,
				'total_amount'=>$total_amount['total_amount'],
				'query_amount'=>$query_amount['query_amount']
				);
			$rechargeInfo = array_merge(array($data),$rechargeInfo);
			
			echo CJSON::encode($rechargeInfo);
			
		}
	}
	//充值对账
	public function actionRecon(){

		$data = array(
			'uid'=>$_GET['uid'],
			'reconid'=>1,
			'url'=>$_GET['uid'] ? $this->createUrl("finance/recon",array('uid'=>$_GET['uid'])) : $this->createUrl("finance/recharge")
			);
		$this->render('recon',$data);

	}
	//清理无效订单
	public function actionDel(){

     	$time = time()-3600 * 72; // 无效订单过期时间
        PayLogs::model()->deleteAll('is_pay=0 AND is_addcoin=0 AND log_time < '.$time);

        echo CJSON::encode(array(1));

	}
	//爵位会员
	public function actionTitleMem(){

		if (Yii::app()->request->isAjaxRequest) {
			
			$where = " 1=1 ";
			
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('gid')) {
				
				$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
				
				if ($uid) {

				 	$where .= " AND uid = '" . $uid . "'";
				}
			}

			
			$order = 'ORDER BY uid DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{user_vip}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$rechargeInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{user_vip}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			$amount_count = 0;
			foreach ($rechargeInfo as $k => $v) {
				
				$rechargeInfo[$k]['gid'] =  User::model()->getUserNicegid($v['uid']);
				$rechargeInfo[$k]['nickname'] =  User::model()->getUserNick($v['uid']);
				$rechargeInfo[$k]['vip_name'] =  Vip::model()->getVipName($v['vip_id']);
				if ($v['type'] == 1) {
					$v['type'] = '道具购买';
				}else if($v['type'] == 2){
					$v['type'] = '后台赠送';
				}else{
					$v['type'] = '升级获得';
				}
				$rechargeInfo[$k]['type'] =  $v['type']; 
				$rechargeInfo[$k]['start_time'] =  date('Y-m-d H:i:s',$v['start_time']);
				$rechargeInfo[$k]['expire_time'] =  date('Y-m-d H:i:s',$v['expire_time']);
				$rechargeInfo[$k]['comefrom'] = User::model()->getFieldsName('comefrom',$v['uid']);
				$rechargeInfo[$k]['is_expire'] = $v['is_expire'] ? '到期' : '正常';
				$rechargeInfo[$k]['operate'] = '<a onclick=del('.$v['uid'].')>删除</a>';
			}

			if($page > $pageCount) $page = $pageCount;

			$data=array(
				'page'=>$page,
				'pageCount'=>$pageCount
				);			
			echo CJSON::encode(array_merge(array($data),$rechargeInfo));
		}else{

			$this->render('titlemem');
		}
	}
	//删除VIP会员
	public function actionDelMem(){
		
		if (Yii::app()->request->isAjaxRequest) {

			if (UserVip::model()->deleteByPk(Yii::app()->request->getParam('uid'))) {
				  
				  echo CJSON::encode(array(1));
			}else{
				  echo CJSON::encode(array(0));
			}	
		}
	}
	//删除VIP会员
	public function actionDelVip(){
		
		if (Yii::app()->request->isAjaxRequest) {

			if (UserVipVip::model()->deleteByPk(Yii::app()->request->getParam('uid'))) {
				  
				  echo CJSON::encode(array(1));
			}else{
				  echo CJSON::encode(array(0));
			}	
		}
	}
	//销售爵位
	public function actionAddTitle(){
		
		if (Yii::app()->request->isAjaxRequest) {
			
			$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));

			$catype = Yii::app()->request->getParam('catype');
			$saletype = Yii::app()->request->getParam('saletype');
			switch ($saletype) {
				case '1':
					$result =UserVip::model()->addVip($uid, $vip_id, false);
					break;
				case '2':
					$result = UserMagic::model()->giveMagic($uid, $vip_id, 1);
					break;	
				default:
					$result =UserVip::model()->addVip($uid, $vip_id, true);
					break;
			}
			
			echo CJSON::encode(array($result));

		}else{

			$result = Vip::model()->vipsList();

			$this->render('addtitle',array('info'=>$result));
		}
	}
	//检测用户号码
	public function actionCheckGid(){

		if (Yii::app()->request->isAjaxRequest) {

			$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
			
			if ($uid) {

				if (!User::model()->checkUid($uid)) {

					echo CJSON::encode(array(0));
				}
			}else{

				echo CJSON::encode(array(0));
			}
			
		}

	}
	//座驾会员
	public function actionCaruser(){

		if (Yii::app()->request->isAjaxRequest) {
			$where = " expired=0 ";
			
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			
			$carname = Yii::app()->request->getParam('carname');
			
			if ($carname) {
				$carid = Car::model()->getCarId($carname);

				
				$where .= " AND car_id = '" . mysqlLikeQuote($carid) . "'";				
			}

			$username = Yii::app()->request->getParam('username');
			
			if ($username) {

				$uid = UserFields::model()->getUid($username);
				
				$where .= " AND uid = '" . mysqlLikeQuote($uid) . "'";				
			}
			
			$order = 'ORDER BY start_time DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT id, uid, car_id, FROM_UNIXTIME(start_time, '%Y-%m-%d %H:%i:%s' ) AS start_time, FROM_UNIXTIME(expire_time, '%Y-%m-%d %H:%i:%s' ) AS expire_time, expired, used FROM {{user_car}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$caruserInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{user_car}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			$amount_count = 0;
			foreach ($caruserInfo as $k => $v) {
				
				$caruserInfo[$k]['car_name'] =  Car::model()->getCarName($v['car_id']);
				$caruserInfo[$k]['user_name'] =  User::model()->getUserNick($v['uid']);
				$caruserInfo[$k]['vip_name'] =  Vip::model()->getVipName($v['vip_id']);
				$caruserInfo[$k]['expired'] = $v['expired'] ? '<span style="cursor:pointer" onClick="changetype('.$v['id'].',0,1'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="changetype('.$v['id'].',1,1'.')"><i class="icon-remove"></i></span>';
				$caruserInfo[$k]['used'] = $v['used'] ? '<span style="cursor:pointer" onClick="changetype('.$v['id'].',0,2'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="changetype('.$v['id'].',1,2'.')"><i class="icon-remove"></i></span>';
				$caruserInfo[$k]['comefrom'] = User::model()->getFieldsName('comefrom',$v['uid']);
				$caruserInfo[$k]['operate'] ='<a href="'.$this->createUrl("finance/caruseredit",array('id'=>$v['id'],'carid'=>$v['car_id'])).'">编辑</a> | '.'<a onclick=del('.$v['id'].')>删除</a>';
			}

			if($page > $pageCount) $page = $pageCount;

			$data=array(
				'page'=>$page,
				'pageCount'=>$pageCount
				);			
			echo CJSON::encode(array_merge(array($data),$caruserInfo));

		}else{

			$this->render('caruser');
		}
	}
	//编辑会员座驾
	public function actionCaruserEdit($id,$carid){

		$carInfo = Car::model()->getCarType();
		$car = UserCar::model()->getCarInfo($id);
		// p($car);
		$data = array(
			'carid'=>$carid,
			'id'=>$car['id'],
			'uid'=>$car['uid'],
			'info'=>$carInfo,
			'expiretime'=>$this->_formatTimeLimit(intval($car['expire_time'])-time())+1,
			);
		$this->render('caruseredit',$data);

	}
	//添加会员座驾
	public function actionCaruserEa(){
		$carInfo = Car::model()->getCarType();
		// p($car);
		$data = array(
			'info'=>$carInfo,
			);
		
		$this->render('caruserea',$data);

	}
	//保存 编辑
	public function actionCaruserAdd(){

		if (Yii::app()->request->isAjaxRequest) {
			$userCar = new UserCar();
			$userCar->uid = $data['uid'] = Yii::app()->request->getParam('uid');	
			$userCar->car_id = $data['car_id'] = Yii::app()->request->getParam('catype');	
			$expiretime = Yii::app()->request->getParam('expiretime');
			$usercarid = Yii::app()->request->getParam('usercarid');
			$userCar->expire_time = $expiretime = $data['expire_time'] = time() + intval($expiretime) * 3600 * 24;
			if ($expiretime) {

				if ($usercarid) {
					$data['start_time'] = time();
					$data['expired'] = 0;
					$data['used'] = 0;
					if (UserCar::model()->updateByPk($usercarid,$data)) {
						echo CJSON::encode(array(2));
					}else{
						echo CJSON::encode(array(3));

					}
					
				}else{
					$userCar->start_time = time();
					$userCar->expired = 0;
					$userCar->used = 0;
					if ($userCar->save()) {
						$CarLogs = new CarLogs();
						$CarLogs->uid = $data['uid'];
						$CarLogs->car_id = $data['car_id'];
						$CarLogs->log_type = 0;
						$CarLogs->car_sum = 1;
						$CarLogs->add_time = time();
						$CarLogs->save();
						echo CJSON::encode(array(2));

					}else{
						echo CJSON::encode(array(3));
					}


				}
			}else{
				echo CJSON::encode(array(0));
			}	

		}

	}

	//核对车信息
	public function actionCheckCar(){

		if (Yii::app()->request->isAjaxRequest) {
			
			if (UserCar::model()->checkUserCar(Yii::app()->request->getParam('catype'),Yii::app()->request->getParam('uid'))) {
				echo CJSON::encode(array(0));
			}
			
		}

	}
	//删除会员座驾
	public function actionDelid(){

		if (Yii::app()->request->isAjaxRequest) {
			
			if (UserCar::model()->deleteByPk(Yii::app()->request->getParam('id'))) {
			
				echo CJSON::encode(array(1));
			}else{
			
				echo CJSON::encode(array(0));
			}

		}	
	}

	//更新会员座驾是否过期、是否使用状态
	public function actionUpdateType(){
		if (Yii::app()->request->isAjaxRequest) {

			$id = Yii::app()->request->getParam('id');
			$status = Yii::app()->request->getParam('status');
			$type = Yii::app()->request->getParam('type');

			
			switch ($type) {
				
				case '1':
					$data = array('expired'=>$status);
					break;
				case '2':
					$data = array('used'=>$status);
					break;
			}

			if (UserCar::model()->updateByPk($id,$data)) {

				echo CJSON::encode(array(1));

			}else{

				echo CJSON::encode(array(0));
			}
			
		}

	}
	public function actionSaleVip(){
		
		if (Yii::app()->request->isAjaxRequest) {
			$where = " 1=1 ";
			
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('gid')) {
				
				$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
				
				if ($uid) {

				 	$where .= " AND uid = '" . mysqlLikeQuote($uid) . "'";
				}
			}

			
			$order = 'ORDER BY uid DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{user_vip_vip}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$rechargeInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{user_vip_vip}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			$amount_count = 0;
			foreach ($rechargeInfo as $k => $v) {
				
				$rechargeInfo[$k]['gid'] =  User::model()->getUserNicegid($v['uid']);
				$rechargeInfo[$k]['nickname'] =  User::model()->getUserNick($v['uid']);
				$rechargeInfo[$k]['vip_name'] =  'vip';
				
				$rechargeInfo[$k]['type'] =  $v['type']==1 ? '后台赠送' :'购买获得'; 
				$rechargeInfo[$k]['start_time'] =  date('Y-m-d H:i:s',$v['start_time']);
				$rechargeInfo[$k]['expire_time'] =  date('Y-m-d H:i:s',$v['expire_time']);
				$rechargeInfo[$k]['comefrom'] = User::model()->getFieldsName('comefrom',$v['uid']);
				$nickname = '';
				if ($v['from_uid']) {
					$nickname = User::model()->getUserNick($v['from_uid']);
				}
				$rechargeInfo[$k]['nickname'] = $nickname ? $nickname : '';
				$rechargeInfo[$k]['is_expire'] =time()> $v['expire_time']? '<span style="color:#f00">到期</span>' : '正常';
				$rechargeInfo[$k]['operate'] = '<a onclick=del('.$v['uid'].')>删除</a>';
			}

			if($page > $pageCount) $page = $pageCount;

			$data=array(
				'page'=>$page,
				'pageCount'=>$pageCount
				);			
			echo CJSON::encode(array_merge(array($data),$rechargeInfo));

		}else{

			$this->render('salevip');
		}

	}
	//销售Vip
	public function actionAddVip(){

		if (Yii::app()->request->isAjaxRequest) {

			$vipid = Yii::app()->request->getParam('catype');

			$fromuid = Yii::app()->request->getParam('fromid');

			$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));

			if (UserVipVip::model()->addVip($uid,$vipid,$fromuid,true)) {
				
				echo CJSON::encode(array(1));

			}else{

				echo CJSON::encode(array(0));
			}

		}else{

			$result = VipVip::model()->vipsList();

			$this->render('addvip',array('info'=>$result));
		}
	}
	//用户充值
	public function actionPay(){
		
		if (Yii::app()->request->isAjaxRequest) {
			$money = Yii::app()->request->getParam('money');
			$addintegral = Yii::app()->request->getParam('addintegral');
			$openagency = Yii::app()->request->getParam('openagency');
			$freegive = Yii::app()->request->getParam('freegive');
			$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
			$discount = Config::model()->getScale('coin_scale');
			$agencyDiscount = Agency::model()->agencyDis($uid);
			// 如果对方是代理
			if ($agencyDiscount){
				// 重新计算代理充值折扣
				if($discount < $agencyDiscount && $openagency == 1) {
					$discount = intval($agencyDiscount);				
				}
			}
			$coin = $money * $discount;
			$nickname = User::model()->getUserNick($uid);
			if (UserAccount::model()->changeCoin($uid, $coin)) {
				$payname = $freegive ? '免费赠送' : '现金充值';
				if(!$agencyDiscount && $addintegral) {
					UserAccount::model()->changeIntegral($uid, $money * intval(Config::model()->getScale('integral_scale')));
				}
				$fromuid=0;
				// 如果是代理, 并且是现金充值
				if($agencyDiscount && !$freegive){
					// 代理人为代理自己
					$fromuid = $uid;
					// 增加代理累积销售额和提成点数
					$sql = "UPDATE {{agency}} SET rank = rank + ('$money') , sales = sales + ('$money') where uid = '$uid'";
					Yii::app()->db->createCommand($sql)->execute();
				}
				UserAccount::model()->payPoint($uid, $money);
				UserAccount::model()->operateVipLevel($uid,$money);
				$suid = User::model()->getSuid($_SESSION['admin__name']);
				PayLogs::model()->addVirtualPayLog($uid, $fromuid, $payname, $coin, $money, $suid);
				echo CJSON::encode(array(1));
			}else{
				echo CJSON::encode(array(0));
			}

		}else{
			
			$this->render('pay');
		}

	}
	//用户扣除
	public function actionPayOff(){

		if (Yii::app()->request->isAjaxRequest) {
			$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
			$point = Yii::app()->request->getParam('point');
			$type = Yii::app()->request->getParam('type');
			$note = Yii::app()->request->getParam('note');
			$nickname = User::model()->getUserNick($uid);
			// echo $type;die();
			if ($type==1) {

				if (UserAccount::model()->changeCoin($uid, $point*-1)) {

					AdminLog::model()->adminLogs("给用户 " . $nickname . "(".Yii::app()->request->getParam('gid').") 成功扣：$point 优币，原因：$note");
					
				}
			}else if($type == 2){
				
				if (UserAccount::model()->changeBean($uid, $point*-1)) {
					AdminLog::model()->adminLogs("给用户 " . $nickname . "(".Yii::app()->request->getParam('gid').") 成功扣：$point 优豆，原因：$note");
					
				}

			}else if($type == 3){

				if (UserAccount::model()->changeIntegral($uid, $point*-1)) {
					AdminLog::model()->adminLogs("给用户 " . $nickname . "(".Yii::app()->request->getParam('gid').") 成功扣：$point 积分，原因：$note");
					
				}

			}
			echo CJSON::encode(array($type));

		}else{
			$this->render('payoff');
		}

	}

	//test导出
	public function actionExport(){
		exportExcel($a,$b,$c);
		exit();
		
	}


	public function filters(){
		return array(
				'accessControl',
			);
	}
	function accessRules() {
        return array(
            array(
                'allow',
                'actions'=>array('recharge','recajax','recon','del','titlemem','delmen','delvip','addtitle','checkgid','caruser','caruseredit','caruserea','caruseradd','checkcar','delid','updatetype','salevip','addvip','pay','payoff'),                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }
	
	private function _formatTimeLimit($time){	
		if ($time == 2147483647){
			$limit = '永久有效';
		}else{
			$limit = intval($time / (3600 * 24));
		}
		return $limit;
	}
}