<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
**家族控制器
*/
class FamilyController extends Controller{
	/*
	*家族列表
	*/
	public function actionIndex(){

		if (Yii::app()->request->isAjaxRequest) {
			$where = " del_flag=0 ";

			
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
		
		$order = 'ORDER BY family_id DESC ';
		
		$start = ($page-1)* PAGE_NUMBER;
    	
    	$monthstart = strtotime(date('Y-m-d', time())) - (date('j', time())-1) * 3600 * 24;

    	$now = time();

		$sql = "SELECT * From {{family}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
		
		$familyInfo = executeSql($sql);

		$sqlCount = "SELECT COUNT(*) as num FROM {{family}} where".$where;
		
		$pageCount = executeSql($sqlCount);
		
		$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
		
		foreach ($familyInfo as $k => $v) {

			$familyInfo[$k]['is_recommend'] = $v['is_recommend'] ? '<span style="cursor:pointer" onClick="recommed('.$v['family_id'].',0,1'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="recommed('.$v['family_id'].',1,1'.')"><i class="icon-remove"></i></span>';
			// $uid = User::model()->getUidByNickname($v['uid']);
			// $familyInfo[$k]['gid'] =  $uid ? $uid : $v['uid'];
			// $familyInfo[$k]['nickname'] = User::model()->getUserNick($v['uid']);
			// $familyInfo[$k]['livetime'] = round($v['livetime']/3600, 3);
			// $familyInfo[$k]['coin'] = $v['coin'] ? $v['coin'] : 0;
			// $familyInfo[$k]['bean'] = $v['bean'] ? $v['bean'] : 0;
			// $familyInfo[$k]['rmb'] = floatval($v['bean']/100);
			$convert = '<a href="'.$this->createUrl('family/anchor',array('fid'=>$v['family_id'],'isanchor'=>2)).'">主播信息</a>';
			$livelogs =  '<a href="'.$this->createUrl('family/user',array('fid'=>$v['family_id'])).'">家族成员</a>';
			$edit = '<a href="'.$this->createUrl('family/add',array('fid'=>$v['family_id'])).'">编辑</a>';
			$delete = '<span style="cursor:pointer;color:#0088cc" onClick="del('.$v['family_id'].')">删除</span>';			
			$familyInfo[$k]['operate'] = $convert.' | '.$livelogs.' | '.$edit.' | '.$delete;
		}

		if($page > $pageCount) $page = $pageCount;

		$familyInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$familyInfo);
		
		echo CJSON::encode($familyInfo);

		}else{
		
			$this->render('index');
		}
	}
	//更新推荐
	public function actionRecommend(){
		if (Yii::app()->request->isAjaxRequest) {

			$fid = Yii::app()->request->getParam('fid');
			$status = Yii::app()->request->getParam('status');
			$type = Yii::app()->request->getParam('type');

			switch ($type) {
				
				case '1':
					$data = array('is_recommend'=>$status);
					break;
			}
			if (Family::model()->updateByPk($fid,$data)) {

					echo CJSON::encode(array(1));

			}else{

				echo CJSON::encode(array(0));
			}
			
		}

	}
	/*
	*家族列表family/add
	*/
	public function actionAdd(){

		if (Yii::app()->request->isAjaxRequest) {
			$fInfo = new Family();
			$fInfo->family_name = $data['family_name'] = Yii::app()->request->getParam('fname');
			$fInfo->family_lead = $data['family_lead'] = $uid = User::model()->getUidByGid(Yii::app()->request->getParam('flead'));
			$fInfo->family_announce = $data['family_announce'] =  Yii::app()->request->getParam('announce');
			$fInfo->family_desc = $data['family_desc'] =  Yii::app()->request->getParam('fdesc');
			$fInfo->family_sign = $data['family_sign'] =  Yii::app()->request->getParam('fsign');
			$fInfo->family_build_time =  date('Y-m-d H:i:s',time());
			$fInfo->family_update_time = $data['family_update_time'] =  date('Y-m-d H:i:s',time());
			$fInfo->del_flag =  0;

    		$fid = Yii::app()->request->getParam('fid') ? Yii::app()->request->getParam('fid') :'';

			if (!FamilyLimits::model()->getUid($uid,$fid)) {
				
				if ($fid) {
					if (Family::model()->updateByPk($fid,$data)) {

						$time = date('Y-m-d H:i:s',time());
						$sql = "update {{family_limits}} set type='1',del_flag='0',update_time='$time' where family_id='$fid' and uid ='$uid'";
						if (Yii::app()->db->createCommand($sql)->execute()) {
							echo CJSON::encode(array(3));
						}else{
							echo CJSON::encode(array(4));
						}
					}else{
						echo CJSON::encode(array(4));
					}
						
				}else{
					if ($fInfo->save()) {
						$fid = Family::model()->getFamilyId(Yii::app()->request->getParam('fname'));
						if ($fid) {
							$fLimits = new FamilyLimits();
							$fLimits->family_id = $fid;
							$fLimits->uid = Yii::app()->request->getParam('flead');
							$fLimits->type = 1;
							$fLimits->is_anchor = 1;
							$fLimits->update_time = date('Y-m-d H:i:s',time());
							$fLimits->del_flag = 0;
							if ($fLimits->save()) {
								echo CJSON::encode(array(1));
							}else{
								echo CJSON::encode(array(0));
							}
						}

					}else{
						
						echo CJSON::encode(array(2));
					}
				}	

			}else{

				echo CJSON::encode(array(0));
			}

		}else{
			
			$finfo = Family::model()->getFamilyName($_REQUEST['fid']);
			// p($finfo);
			$data['fid'] = $_REQUEST['fid'];
			$data['fname'] = $finfo['family_name'];
			$data['flead'] = $finfo['family_lead'];
			$data['announce'] = $finfo['family_announce'];
			$data['fdesc'] = $finfo['family_desc'];
			$data['fsign'] = $finfo['family_sign'];
			$this->render('add',$data);
		}
	}
	//主播信息
	//本月家族贡献：0元RMB，您的收益为0*0=0元RMB 在老系统没有数据
	public function actionAnchor(){

		if (Yii::app()->request->isAjaxRequest) {

			$where = "1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			$starttime = Yii::app()->request->getParam('starttime');
			$endtime = Yii::app()->request->getParam('endtime');
			
			if ($starttime && $endtime) {
				
				$timelimit = " and add_time <='".strtotime($endtime)."' AND add_time >='".strtotime($starttime)."'";
				$stimelimit = " and ender_time <='".strtotime($endtime)."' AND ender_time >='".strtotime($starttime)."'";
			}else if ($starttime && !$endtime) {
	
				$timelimit = " and add_time >= '".strtotime($starttime)."'";
				$stimelimit = " and ender_time >= '".strtotime($starttime)."'";
			}else if (!$starttime && $endtime){
			
				$timelimit = " and add_time <= '".strtotime($endtime)."'";
				$stimelimit = " and ender_time <= '".strtotime($endtime)."'";
			}
			
			if (Yii::app()->request->getParam('fid')) {
				$where .= " AND family_id = '" .Yii::app()->request->getParam('fid'). "'";
			}
			if (Yii::app()->request->getParam('isanchor')) {
				$where .= " AND is_anchor = '" .Yii::app()->request->getParam('isanchor'). "'";
			}

			$order = 'ORDER BY family_id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{family_limits}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$anchorInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{family_limits}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($anchorInfo as $k => $v) {

				$anchorInfo[$k]['fname'] = Family::model()->getFname($v['family_id']);
				$anchorInfo[$k]['uname'] = User::model()->getUserNick($v['uid']);
				$anchorInfo[$k]['gid'] = User::model()->getUserNicegid($v['uid']);
				$anchorInfo[$k]['icome'] = GiftLogs::model()->getTprice("to_uid ='".$v['uid']."'".$timelimit);
				$anchorInfo[$k]['live_count'] = round(LiveLogs::model()->getLtime("uid ='".$v['uid']."'".$stimelimit)/3600,3);
				
			}

			if($page > $pageCount) $page = $pageCount;

			$anchorInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$anchorInfo);
			
			echo CJSON::encode($anchorInfo);

		}else{
			
			$data = array(
				'fid'=>$_REQUEST['fid'],
				'isanchor'=>$_REQUEST['isanchor']
				);

			$this->render('anchor',$data);
		}

	}
	public function actionUser(){
		if (Yii::app()->request->isAjaxRequest) {
			
			$where = "1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
						
			if (Yii::app()->request->getParam('fid')) {
				$where .= " AND family_id = '" .Yii::app()->request->getParam('fid'). "'";
			}
			if (Yii::app()->request->getParam('isanchor')) {
				$where .= " AND is_anchor = '" .Yii::app()->request->getParam('isanchor'). "'";
			}
			if (Yii::app()->request->getParam('uname')) {
				$uid = User::model()->getUidByNickname(Yii::app()->request->getParam('uname'));
				$where .= " AND uid = '" .$uid. "'";
			}

			$order = 'ORDER BY family_id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{family_limits}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$userInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{family_limits}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			$userType = $this->_userType();
			foreach ($userInfo as $k => $v) {

				$userInfo[$k]['fname'] = Family::model()->getFname($v['family_id']);
				$userInfo[$k]['uname'] = User::model()->getUserNick($v['uid']);
				$userInfo[$k]['gid'] = User::model()->getUserNicegid($v['uid']);
				$userInfo[$k]['type'] = $userType[$v['type']];
				$userInfo[$k]['isanchor'] = $v['is_anchor']=='2' ? '是' :'否';
				$userInfo[$k]['operate'] ='<a href="'.$this->createUrl("family/adduser",array('uid'=>$v['uid'],'fid'=>$v['family_id'],'type'=>$v['type'],'isanchor'=>$v['is_anchor'])).'">编辑</a> | '.'<a onclick=del('.$v['uid'].','.$v['family_id'].')>删除</a>';
			}

			if($page > $pageCount) $page = $pageCount;

			$userInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$userInfo);
			
			echo CJSON::encode($userInfo);

		}else{
			
			$data = array(
				'fid'=>$_REQUEST['fid'],
				'isanchor'=>$_REQUEST['isanchor']
				);

			$this->render('user',$data);
		}
	}
	public function actionAddUser(){

		if (Yii::app()->request->isAjaxRequest) {
			$familyInfo = new FamilyLimits();
			$familyInfo->type = $type = Yii::app()->request->getParam('ptype');
			$familyInfo->is_anchor = $isanchor = Yii::app()->request->getParam('atype');
			$familyInfo->family_id =  Yii::app()->request->getParam('fid');
			$familyInfo->uid = $uid =   User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
			$familyInfo->update_time = $time =  date('Y-m-d H:i:s',time());
			$familyInfo->del_flag = 0;
			$fid = Yii::app()->request->getParam('status') ? Yii::app()->request->getParam('fid') :'';
			$atype = Yii::app()->request->getParam('gid');
			if (!FamilyLimits::model()->getUid($uid,$fid)) {
				if (Anchor::model()->isAnchor($uid)) {
					$familyInfo->is_anchor = $isanchor = 2;
				}
				if ($fid) {
					$sql = "update {{family_limits}} set type='$type',is_anchor='$isanchor',update_time='$time' where family_id='$fid' and uid ='$uid'";
					if (Yii::app()->db->createCommand($sql)->execute()) {
						echo CJSON::encode(array(3));
					}else{
						echo CJSON::encode(array(4));
					}
						
				}else{
					if ($familyInfo->save()) {
					
						echo CJSON::encode(array(1));
					}else{
						
						echo CJSON::encode(array(2));
					}
				}	

			}else{

				echo CJSON::encode(array(0));
			}
			


		}else{
			$finfo = Family::model()->getFamilyName($_REQUEST['fid']);
			// p($finfo);
			$data = array(
				'fname'=>$finfo['family_name'],
				'uid'=>$_REQUEST['uid'],
				'ptype'=>$_REQUEST['type'],
				'atype'=>$_REQUEST['isanchor'],
				'fid'=>$_REQUEST['fid'],
				);	
			$this->render('adduser',$data);
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
	//删除家族成员
	public function actionDel(){
		if (Yii::app()->request->isAjaxRequest) {
			$uid = Yii::app()->request->getParam('uid');
			$fid = Yii::app()->request->getParam('fid');
			if (Yii::app()->db->createCommand("delete from {{family_limits}} where uid=$uid and family_id=$fid")->execute()) {
				echo CJSON::encode(array(1));
			}else{
				echo CJSON::encode(array(0));
			}
		}
	}
	private function _userType(){
		return array('1'=>'族长','2'=>'家族管理','3'=>'家族成员','4'=>'待批准成员','5'=>'禁止申请成员');
	}

	function filters(){
		return array(
			'accessControl',
		);
	}
	function accessRules() {
        return array(
            array(
                'allow',
                'actions'=>array('index','anchor','user','add','adduser','recommend','checkgid','del'),
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