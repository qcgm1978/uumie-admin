<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
*主播模块
* author :zzh
*/
class AnchorController extends Controller{


	public function actionIndex(){

		if (Yii::app()->request->isAjaxRequest) {
			
			$where = " 1=1 ";

			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;

			$username = Yii::app()->request->getParam('username');
			
			if ($username) {

				$uid = User::model()->getUidByNickname($username);
				if ($uid) {

					$where .= " AND a.uid = '$uid'";
				}
			}
			$gid = Yii::app()->request->getParam('gid');
			if ($gid) {

				$uid = User::model()->getUidByGid($gid);

				if ($uid) {
					$where .= " AND a.uid = '$uid'";
				}
			}
		
		$order = 'ORDER BY a.uid DESC ';
		
		$start = ($page-1)* PAGE_NUMBER;
    	
    	$monthstart = strtotime(date('Y-m-d', time())) - (date('j', time())-1) * 3600 * 24;

    	$now = time();

		$sql = "SELECT a.uid AS uid,b.bean AS bean,	b.coin AS coin,	(SELECT	SUM(seconds) FROM {{live_logs}} WHERE ender_time > '.$monthstart.' AND ender_time < '.$now.' AND uid = a.uid) AS livetime FROM	{{anchor}} AS a LEFT JOIN  {{user_account}} AS b ON a.uid = b.uid where ".$where.$order."limit "."$start,". PAGE_NUMBER;
		
		$anchorInfo = executeSql($sql);

		$sqlCount = "SELECT COUNT(*) as num, (SELECT	SUM(seconds) FROM {{live_logs}} WHERE ender_time > '.$monthstart.' AND ender_time < '.$now.' AND uid = a.uid) AS livetime FROM	{{anchor}} AS a LEFT JOIN  {{user_account}} AS b ON a.uid = b.uid where ".$where;
		
		$pageCount =executeSql($sqlCount);
		
		$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
		
		foreach ($anchorInfo as $k => $v) {

			$uid = User::model()->getUidByNickname($v['uid']);
			$anchorInfo[$k]['gid'] =  $uid ? $uid : $v['uid'];
			$anchorInfo[$k]['nickname'] = User::model()->getUserNick($v['uid']);
			$anchorInfo[$k]['livetime'] = round($v['livetime']/3600, 3);
			$anchorInfo[$k]['coin'] = $v['coin'] ? $v['coin'] : 0;
			$anchorInfo[$k]['bean'] = $v['bean'] ? $v['bean'] : 0;
			$anchorInfo[$k]['rmb'] = floatval($v['bean']/100);
			$convert = $anchorInfo[$k]['rmb'] > 1 ?'<a href="'.$this->createUrl('anchor/convert',array('uid'=>$v['uid'])).'">兑点</a>':'兑点';
			$livelogs =  '<a href="'.$this->createUrl('anchor/livelogs',array('uid'=>$v['uid'])).'">麦时</a>';
			$edit = '<a href="'.$this->createUrl('anchor/edit',array('uid'=>$v['uid'])).'">编辑</a>';
			$delete = '<span style="cursor:pointer;color:#0088cc" onClick="del('.$v['uid'].')">删除</span>';			
			$anchorInfo[$k]['answer'] = $convert.' | '.$livelogs.' | '.$edit.' | '.$delete;
		}

		if($page > $pageCount) $page = $pageCount;

		$anchorInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$anchorInfo);
		
		echo CJSON::encode($anchorInfo);

		}else{

			$this->render('index');
		}
	}
	//导出
	public function actionExport(){
		// echo phpinfo();exit();
		// $header = array(
		// 	'uid'=>'用户号码',
		// 	'name'=>'用户姓名',
		// 	'bankname'=>'银行名称',
		// 	'banknum'=>'银行卡号',
		// 	'alipay'=>'支付宝'
		// );
		$sql = "SELECT uid,name,bankname,banknum,alipay FROM {{anchor}} ORDER BY uid DESC limit 100,100";
		$anchorInfo = yii::app()->db->createCommand($sql)->queryAll();
		// exportPhpExcel('主播申请列表',$header,$anchorInfo);	

		$exarr = array(
		     'uid'	=>array('name'=>'用户号码'),
		     'name'	=>array('name'=>'用户姓名'),
		     'bankname'	=>array('name'=>'银行名称'),
		     'banknum'	=>array('name'=>'银行卡号'),
		     'alipay'	=>array('name'=>'支付宝'),
		);
		// p($anchorInfo);exit();
		$filename = '主播导出'.date('Ymd',time());

		export_csv($filename ,$exarr, $anchorInfo);	
	}
	//删除主播
	public function actionDelete(){

		if (Yii::app()->request->isAjaxRequest) {
			
			if (Anchor::model()->deleteByPk(Yii::app()->request->getParam('uid'))) {
				
				echo CJSON::encode(array(1));
			
			}else{

				echo CJSON::encode(array(0));
			}
		}
	}
	//麦时记录
	public function actionLiveLogs(){
		
		if (Yii::app()->request->isAjaxRequest) {

			$where = " 1=1 ";
				
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('starttime')) {
				$where .= " and ender_time >= '".strtotime(Yii::app()->request->getParam('starttime'))."'";
			}
			if (Yii::app()->request->getParam('endtime')) {
				$where .= " and ender_time <= '".strtotime(Yii::app()->request->getParam('endtime'))."'";
			}	

			$roomid = Yii::app()->request->getParam('roomid');
			
			if ($roomid) {

				$where .= " AND room_id = '" .$roomid. "' ";
			}

			$uid = Yii::app()->request->getParam('uid');
			
			if ($uid) {

				$where .= " AND uid = '" .$uid. "' ";
			}
			
			$gid = Yii::app()->request->getParam('gid');
			
			if ($gid) {
				$uid = User::model()->getUidByNickname($gid);
				$where .= " AND uid = '" . $uid . "'";
			}

			
			$order = 'ORDER BY ender_time DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{live_logs}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$liveLogs = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{live_logs}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($liveLogs as $k => $v) {

				$liveLogs[$k]['nickname'] = '<a href="'.$this->createUrl('anchor/livelogs',array('uid'=>$v['uid'])).'" >'.User::model()->getUserNick($v['uid']).'</a>';
				$liveLogs[$k]['seconds'] = round($v['seconds'] / 3600, 3);
				$liveLogs[$k]['room_name'] = '<a href="'.$this->createUrl('anchor/livelogs',array('roomid'=>$v['room_id'])).'" >'.Room::model()->getRoomName($v['room_id']).'</a>';
				$liveLogs[$k]['starttime'] = date('Y-m-d H:i:s',$v['start_time']);
				$liveLogs[$k]['endtime'] = date('Y-m-d H:i:s',$v['ender_time']);
				
			}

			if($page > $pageCount) $page = $pageCount;

			$liveLogs = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$liveLogs);
			
			echo CJSON::encode($liveLogs);

		}else{

			if ($_REQUEST['uid']) {
				$key = 'uid';
				$val = $_REQUEST['uid'];
			}else if($_REQUEST['roomid']){
				$key = 'roomid';
				$val = $_REQUEST['roomid'];
			}
			
			$data = array(
				'uid' => $_REQUEST['uid'],
				'roomid'=>$_REQUEST['roomid'],
				'key'=>$key,
				'val'=>$val,
				'starttime'=>date('m/d/Y',strtotime(date('Y-m-d', time())) - (date('j', time())-1) * 3600 * 24),
				'endtime'=>date('m/d/Y',time()),
				);
			// p($data);
			$this->render('livelogs',$data);
		}
	}

	public function actionEdit($uid){

		$result = Anchor::model()->allAnchor($uid);

		$data = array(
			'uid'=>$result['uid'],
			'name'=>$result['name'],
			'bankname'=>$result['bankname'],
			'banknum'=>$result['banknum'],
			'alipay'=>$result['alipay'],
			);
		
		$this->render('edit',$data);
	}

	public function actionAdd(){

		if (Yii::app()->request->isAjaxRequest) {
				
				$anchor = new Anchor();
				$anchor->name = $data['name'] = Yii::app()->request->getParam('name') ? trim(Yii::app()->request->getParam('name')) :'';
				$anchor->bankname = $data['bankname'] = Yii::app()->request->getParam('bankname') ? trim(Yii::app()->request->getParam('bankname')) :'';
				$anchor->banknum = $data['banknum'] = Yii::app()->request->getParam('banknum') ? nStr(trim(Yii::app()->request->getParam('banknum'))) :'';
				$anchor->alipay = $data['alipay'] = Yii::app()->request->getParam('alipay') ? trim(Yii::app()->request->getParam('alipay')) :'';
				$anchor->uid = $uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
				
				$update = Yii::app()->request->getParam('update');
				
				if (Yii::app()->request->getParam('update')) {
					
					if (Anchor::model()->updateByPk($uid, $data)) {
						
						echo CJSON::encode(array(1));

					}else{
						
						echo CJSON::encode(array(0));
					 }

				}else{

					if ($anchor->save()) {

						echo CJSON::encode(array(1));

					}else{

						echo CJSON::encode(array(0));
					}
				}
				

		}else{

			$this->render('add');
		}
	}
	//判断用户号码
	public function actionCheckGid(){

		if (Yii::app()->request->isAjaxRequest) {
			
			$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));

			if (User::model()->checkUid($uid)) {

				if (Anchor::model()->isAnchor($uid)) {
						
					echo CJSON::encode(array(2));

				}else{

					echo CJSON::encode(array(1));
				}
				
			}else{

				echo CJSON::encode(array(0));
			}

		}
	}
	
	//兑换列表
	public function actionCash(){

		if (Yii::app()->request->isAjaxRequest) {
			
			$where = "1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('username')) {

				$uid = User::model()->getUidByNickname(Yii::app()->request->getParam('username'));
				
				if ($uid) {
					$where .= " AND uid = '$uid'";
				}
				
			}

			if (Yii::app()->request->getParam('gid')) {

				$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));

				if ($uid) {
					$where .= " AND uid = '$uid'";
				}
			}

			$order = 'ORDER BY uid DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{cash}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			// echo $sql;exit();
			$cashInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{cash}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($cashInfo as $k => $v) {

				$cashInfo[$k]['gid'] = User::model()->getUserNicegid($v['uid']);
				$cashInfo[$k]['nickname'] = User::model()->getUserNick($v['uid']);
				$cashInfo[$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
				
			}

			if($page > $pageCount) $page = $pageCount;

			$cashInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$cashInfo);
			
			echo CJSON::encode($cashInfo);


		}else{

			$this->render('cash');
		}
	}

	//主播申请列表
	public function actionApply(){

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
	
			$sql = "SELECT * FROM {{apply_anchor}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$cashInfo = executeSql($sql);
			// p($cashInfo);exit();

			$sqlCount = "SELECT COUNT(*) as num FROM {{apply_anchor}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($cashInfo as $k => $v) {

				$cashInfo[$k]['add_time_str'] = date('Y-m-d H:i:s', $v['add_time']);
				
			}
			
			if($page > $pageCount) $page = $pageCount;

			$cashInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$cashInfo);
			
			echo CJSON::encode($cashInfo);

		}else{

			$this->render('apply');
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
				'actions'=>array('index','export','delete','livelogs','edit','checkgid','add','cash','apply'),
                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }

	
	
}