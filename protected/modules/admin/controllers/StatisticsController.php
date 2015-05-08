<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
**数据统计控制器
*/
class StatisticsController extends Controller{

	/*
	*礼物记录
	*/
	public function actionGift(){

		if (Yii::app()->request->isAjaxRequest) {
			$where = "1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('starttime')) {
				$where .= " and add_time >= '".strtotime(Yii::app()->request->getParam('starttime'))."'";
			}
			if (Yii::app()->request->getParam('endtime')) {
				$where .= " and add_time <= '".strtotime(Yii::app()->request->getParam('endtime'))."'";
			}
			$presenter = Yii::app()->request->getParam('presenter');
			if ($presenter) {
				$where .= " AND from_uid = '" .$presenter. "'";
			}
			$recipient = Yii::app()->request->getParam('recipient');
			if ($recipient) {
				$where .= " AND to_uid = '" .$recipient. "'";
			}
			$roomid = Yii::app()->request->getParam('roomid');
			if ($roomid) {
				$where .= " AND room_id = '" .$roomid. "'";
			}
			$giftname = Yii::app()->request->getParam('giftname');
			if ($giftname) {
				$where .= " AND gift_name = '" .$giftname. "'";
			}
			$getype = Yii::app()->request->getParam('getype');
			if ($getype) {
				$where .= " AND gift_from = '" .$getype. "'";
			}
			$familyname = Yii::app()->request->getParam('familyname');
	
			if ($familyname) {
				$familyId = Family::model()->getFamilyId($familyname);
				$where .= " AND EXISTS (SELECT 1 FROM {{family_limits}} WHERE  uid = to_uid AND family_id=".$familyId.")";				
			}

			$order = 'ORDER BY id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT from_uid, to_uid, gift_sum, gift_name, gift_from, room_id, total_price, add_time FROM {{gift_logs}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			// echo $sql;
			$giftInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{gift_logs}} where ".$where;
			// echo $sqlCount;exit();
			$pageCount = executeSql($sqlCount);
			
			$sqlAmount = "SELECT SUM(gift_sum) as gift_sum FROM {{gift_logs}} where ".$where;
			// echo $sqlCount;exit();
			$queryAmount = executeSql($sqlAmount);
			$amount_count = $queryAmount[0]['gift_sum'];

			$sqlTotal = "SELECT SUM(total_price) as total_price FROM {{gift_logs}} where ".$where;
			// echo $sqlCount;exit();
			$queryTotal = executeSql($sqlTotal);
			$queryTotal = $queryTotal[0]['total_price'];
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($giftInfo as $k => $v) {

				$giftInfo[$k]['from_nickname'] = '<a href="'.$this->createUrl("statistics/gift",array('presenter'=>$v['from_uid'])).'">'.User::model()->getUserNick($v['from_uid']).'('.User::model()->getUserNicegid($v['from_uid']).')'.'</a>';
				$giftInfo[$k]['to_nickname'] = '<a href="'.$this->createUrl("statistics/gift",array('recipient'=>$v['to_uid'])).'">'.User::model()->getUserNick($v['to_uid']).'('.User::model()->getUserNicegid($v['to_uid']).')'.'</a>';
				$giftInfo[$k]['room_name'] = '<a href="'.$this->createUrl("statistics/gift",array('roomid'=>$v['room_id'])).'">'.Room::model()->getRoomName($v['room_id']).'('.$v['room_id'].')'.'</a>';
				// $giftInfo[$k]['room_name'] = Room::model()->getRoomName($v['room_id']);
				$giftInfo[$k]['how_get'] = $this->_magicName($v['gift_from']);
				$giftInfo[$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
				if ($v['gift_from']) {
					$str = '(<a style="color:#f00" href="'.$this->createUrl("statistics/gift",array('gift_from'=>$v['gift_from'])).'">'.$giftInfo[$k]['how_get'].'</a>)';
				}
				$giftInfo[$k]['gift_name'] = '<a href="'.$this->createUrl("statistics/gift",array('giftname'=>$v['gift_name'])).'">'.$v['gift_name'].'</a>'.$str;
			}

			if($page > $pageCount) $page = $pageCount;

			$giftInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount,'total_amount'=>$queryTotal,'amount_count'=>$amount_count)),$giftInfo);
			
			echo CJSON::encode($giftInfo);
		}else{

			if ($_REQUEST['presenter']) {
				$key = 'presenter';
				$val = $_REQUEST['presenter'];
			}else if($_REQUEST['recipient']){
				$key = 'recipient';
				$val = $_REQUEST['recipient'];
			}else if($_REQUEST['roomid']){
				$key = 'roomid';
				$val = $_REQUEST['roomid'];
			}else if($_REQUEST['giftname']){
				$key = 'giftname';
				$val = $_REQUEST['giftname'];
			}
			$data = array(
				'presenter'=>$_REQUEST['presenter'],
				'recipient'=>$_REQUEST['recipient'],
				'roomid'=>$_REQUEST['roomid'],
				'giftname'=>$_REQUEST['giftname'],
				'key'=>$key,
				'val'=>$val
				);

			$this->render('gift',$data);
		}
	}
	//每日统计
	public function actionDaily(){

		if (Yii::app()->request->isAjaxRequest) {
			
			$where = "1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('starttime')) {
				$where .= " and add_time >= '".strtotime(Yii::app()->request->getParam('starttime'))."'";
			}
			if (Yii::app()->request->getParam('endtime')) {
				$where .= " and add_time <= '".strtotime(Yii::app()->request->getParam('endtime'))."'";
			}
			$order = 'ORDER BY id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{statistics_logs}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$dailyInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{statistics_logs}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($dailyInfo as $k => $v) {

				$dailyInfo[$k]['add_time'] = date('Y-m-d', $v['add_time']);
				$dailyInfo[$k]['consume_sum'] = '<a href="'.$this->createUrl("statistics/consume",array('consume'=>date('Y-m-d', $v['add_time']))).'">'.$v['consume_sum'].'</a>';
				$dailyInfo[$k]['pay_scc_count'] = '<a href="'.$this->createUrl("statistics/pay",array('pay'=>date('Y-m-d', $v['add_time']))).'">'.$v['pay_scc_count'].'</a>';
				$dailyInfo[$k]['login_count'] = '<a href="'.$this->createUrl("statistics/login",array('login'=>date('Y-m-d', $v['add_time']))).'">'.$v['login_count'].'</a>';
				$dailyInfo[$k]['gift_count'] = '<a href="'.$this->createUrl("statistics/giftcount",array('giftcount'=>date('Y-m-d', $v['add_time']))).'">'.$v['gift_count'].'</a>';
			}

			if($page > $pageCount) $page = $pageCount;

			$dailyInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$dailyInfo);
			
			echo CJSON::encode($dailyInfo);

		}else{

			$this->render('daily');
		}
	}
	public function actionConsume(){
		
		if (Yii::app()->request->isAjaxRequest) {
			
			$where = "1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('starttime')) {
				$where .= " and consume_time >= '".strtotime(Yii::app()->request->getParam('starttime'))."'";
			}
			if (Yii::app()->request->getParam('endtime')) {
				$where .= " and consume_time <= '".strtotime(Yii::app()->request->getParam('endtime'))."'";
			}
			$order = 'ORDER BY id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT FROM_UNIXTIME(consume_time,'%Y-%m-%d') AS times,
			SUM(CASE WHEN consume_type = 0 THEN consume_coin ELSE 0 END) AS gift_consume,
			SUM(CASE WHEN consume_type = 1 THEN consume_coin ELSE 0 END) AS car_consume,
			SUM(CASE WHEN consume_type = 2 THEN consume_coin ELSE 0 END) AS num_consume,
			SUM(CASE WHEN consume_type = 3 THEN consume_coin ELSE 0 END) AS speak_consume,
			SUM(CASE WHEN consume_type = 4 THEN consume_coin ELSE 0 END) AS vip_consume FROM  {{consume_log}} where ".$where." GROUP BY FROM_UNIXTIME(consume_time,'%Y-%m-%d') ".$order."limit "."$start,". PAGE_NUMBER;
			// echo $sql;exit();
			$cashInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM (SELECT consume_time
			 FROM {{consume_log}} WHERE $where GROUP BY FROM_UNIXTIME(consume_time,'%Y-%m-%d')) t";
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			// p($pageCount);
			if($page > $pageCount) $page = $pageCount;

			$cashInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$cashInfo);
			
			echo CJSON::encode($cashInfo);

		}else{

			$data = array(
				'starttime'=>date('m/d/Y',strtotime($_REQUEST['consume'])),
				'endtime'=>date('m/d/Y',strtotime($_REQUEST['consume'])),
				);
			$this->render('consume',$data);
		}
	}
	public function actionGiftCount(){
		
		if (Yii::app()->request->isAjaxRequest) {
			
			$where = " Where 1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('starttime')) {
				$where .= " and add_time >= '".strtotime(Yii::app()->request->getParam('starttime'))."'";
			}
			if (Yii::app()->request->getParam('endtime')) {
				$where .= " and add_time <= '".strtotime(Yii::app()->request->getParam('endtime'))."'";
			}
			$order = 'ORDER BY times DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT t.times,GROUP_CONCAT(t.gift ORDER BY t.s DESC SEPARATOR ' ') as gift FROM (
				SELECT FROM_UNIXTIME(add_time,'%Y-%m-%d') AS times,CONCAT(gift_name,SUM(gift_sum)) AS gift, SUM(gift_sum) AS s  
				FROM {{gift_logs}} $where "."  GROUP BY FROM_UNIXTIME(add_time,'%Y-%m-%d'),gift_name order by FROM_UNIXTIME(add_time,'%Y-%m-%d') DESC,SUM(gift_sum) DESC ) t GROUP BY t.times ".$order."limit "."$start,". PAGE_NUMBER;;
			// echo $sql;exit();
			$cashInfo = executeSql($sql);

			$sqlCount = "SELECT count(*) as num FROM (
        			SELECT t.times,GROUP_CONCAT(t.gift) FROM (
						SELECT FROM_UNIXTIME(add_time,'%Y-%m-%d') AS times,
							CONCAT(gift_name,SUM(gift_sum)) AS gift 
						FROM {{gift_logs}} $where 
						GROUP BY FROM_UNIXTIME(add_time,'%Y-%m-%d'),gift_name  
						ORDER BY FROM_UNIXTIME(add_time,'%Y-%m-%d') DESC,SUM(gift_sum) DESC ) t 
					GROUP BY t.times ) m";
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			// p($pageCount);
			if($page > $pageCount) $page = $pageCount;

			$cashInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$cashInfo);
			
			echo CJSON::encode($cashInfo);

		}else{

			$data = array(
				'starttime'=>date('m/d/Y',strtotime($_REQUEST['giftcount'])),
				'endtime'=>date('m/d/Y',strtotime($_REQUEST['giftcount'])),
				);
			$this->render('giftcount',$data);
		}
	}
	//每日统计
	public function actionLogin(){

		if (Yii::app()->request->isAjaxRequest) {
						
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			$starttime = Yii::app()->request->getParam('starttime');
			$endtime = Yii::app()->request->getParam('endtime');
			$login_count = Yii::app()->request->getParam('login_count');
			$login_count = empty($login_count) ? 1 :trim($login_count);

			if ($starttime) {
				$where .= " and l.add_time >= '".mysqlLikeQuote(strtotime($starttime))."'";
			}
			if ($endtime) {
				$where .= " and l.add_time <= '".mysqlLikeQuote(strtotime($endtime)+3600*24)."'";
			}
			$order = 'ORDER BY t.comefrom DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT t.comefrom AS comefrom,
			COUNT(CASE WHEN t.uid<>0 THEN 1 END) AS u_count,
			COUNT(CASE WHEN t.uid=0 THEN 1 END) AS c_count 
			 FROM (
			SELECT 
			comefrom,l.uid,l.add_time FROM c_user_in_logs_query l where (l.comefrom='' or CHAR_LENGTH(TRIM(l.comefrom))=10) ".$where." GROUP BY l.xid,l.uid
			HAVING COUNT(l.uid)>=".$login_count.") t 
			GROUP BY t.comefrom  ".$order."limit "."$start,". PAGE_NUMBER;
			
			$dailyInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM (SELECT t.comefrom AS comefrom,
					COUNT(CASE WHEN t.uid<>0 THEN 1 END) AS u_count,
					COUNT(CASE WHEN t.uid=0 THEN 1 END) AS c_count 
					 FROM (
					SELECT 
					comefrom,l.uid,l.add_time FROM {{user_in_logs_query}} l WHERE (l.comefrom='' or CHAR_LENGTH(TRIM(l.comefrom))=10) $where
					GROUP BY l.xid,l.uid
					HAVING COUNT(l.uid)>=".$login_count.") t 
					GROUP BY t.comefrom ) m";
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($dailyInfo as $k => $v) {

				$dailyInfo[$k]['add_time'] = date('Y-m-d', $v['add_time']);
				$dailyInfo[$k]['consume_sum'] = '<a href="'.$this->createUrl("statistics/consume",array('consume'=>date('Y-m-d', $v['add_time']))).'">'.$v['consume_sum'].'</a>';
				$dailyInfo[$k]['pay_scc_count'] = '<a href="'.$this->createUrl("statistics/pay",array('pay'=>date('Y-m-d', $v['add_time']))).'">'.$v['pay_scc_count'].'</a>';
				$dailyInfo[$k]['login_count'] = '<a href="'.$this->createUrl("statistics/login",array('login'=>date('Y-m-d', $v['add_time']))).'">'.$v['login_count'].'</a>';
				$dailyInfo[$k]['gift_count'] = '<a href="'.$this->createUrl("statistics/giftcount",array('giftcount'=>date('Y-m-d', $v['add_time']))).'">'.$v['gift_count'].'</a>';
			}

			if($page > $pageCount) $page = $pageCount;

			$dailyInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$dailyInfo);
			
			echo CJSON::encode($dailyInfo);

		}else{
			
			$data = array(
				'starttime'=>date('m/d/Y',strtotime($_REQUEST['login'])),
				'endtime'=>date('m/d/Y',strtotime($_REQUEST['login'])),
				);
			$this->render('login',$data);
		}
	}
	public function actionPay(){
		
		if (Yii::app()->request->isAjaxRequest) {
			
			$where = "is_pay=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			$starttime = Yii::app()->request->getParam('starttime');
			$endtime = Yii::app()->request->getParam('endtime');
			
			if ($starttime) {
				$where .= " and add_time >= '".mysqlLikeQuote(strtotime($starttime))."'";
			}
			if ($endtime) {
				$where .= " and add_time <= '".mysqlLikeQuote(strtotime($endtime)+3600*24)."'";
			}
			$order = 'ORDER BY times DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT t.times AS times,
					COUNT(CASE WHEN t.amount<10 THEN 1 END) AS pay_count,
					COUNT(CASE WHEN t.amount BETWEEN 10 AND 30 THEN 1 END) AS pay_count1,
					COUNT(CASE WHEN t.amount BETWEEN 31 AND 50 THEN 1 END) AS pay_count2,
					COUNT(CASE WHEN t.amount BETWEEN 51 AND 99 THEN 1 END) AS pay_count3,
					COUNT(CASE WHEN t.amount>=100 THEN 1 END) AS pay_count4
					FROM (
					SELECT FROM_UNIXTIME(add_time,'%Y-%m-%d') AS times ,SUM(amount) AS amount,uid FROM  {{pay_logs}} where ".$where." GROUP BY FROM_UNIXTIME(add_time,'%Y-%m-%d'),uid ) t  GROUP BY t.times ".$order."limit "."$start,". PAGE_NUMBER;
			// echo $sql;exit();
			$cashInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM (SELECT t.times,
				COUNT(CASE WHEN t.amount<10 THEN 1 END) AS pay_count,
				COUNT(CASE WHEN t.amount BETWEEN 10 AND 30 THEN 1 END) AS pay_count1,
				COUNT(CASE WHEN t.amount BETWEEN 31 AND 50 THEN 1 END) AS pay_count2,
				COUNT(CASE WHEN t.amount BETWEEN 51 AND 99 THEN 1 END) AS pay_count3,
				COUNT(CASE WHEN t.amount>=100 THEN 1 END) AS pay_count4 
				FROM 
				(SELECT FROM_UNIXTIME(add_time,'%Y-%m-%d') AS times ,SUM(amount) AS amount,uid FROM 
				{{pay_logs}} Where $where GROUP BY FROM_UNIXTIME(add_time,'%Y-%m-%d'),uid ) t  GROUP BY t.times ) m"; 
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			// p($pageCount);
			if($page > $pageCount) $page = $pageCount;

			$cashInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$cashInfo);
			
			echo CJSON::encode($cashInfo);

		}else{

			$data = array(
				'starttime'=>date('m/d/Y',strtotime($_REQUEST['pay'])),
				'endtime'=>date('m/d/Y',strtotime($_REQUEST['pay'])),
				);
			$this->render('pay',$data);
		}
	}
	private function _magicName($id){

		$magics = array(1=>'黄袋', 2=>'蓝袋', 3=>'紫袋');

		if ($magic_id){	

			return $magics[$id];
		}else{
			return '';
		}
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
                'actions'=>array('gift','daily','consume','giftcount','login','pay'),
                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }

}
?>