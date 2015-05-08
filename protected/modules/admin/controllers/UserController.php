<?php
/*
*会员模块
*/
class UserController extends Controller{
	/*
	*会员列表
	*/
	public function actionIndex(){
		$cri = new CDbCriteria();
		
		$userModel = User::model();
		
		$total = $userModel->count($cri);
		
		$pager = new CPagination($total);
		$pager->pageSize = 30;
		$pager->applyLimit($cri);
		
		$userInfo = $userModel->findAll($cri);
		
		$sql = "SELECT * FROM {{user}} u LEFT JOIN {{number_sold}} s ON s.uid = u.gid LIMIT 20";
		
		$userInfo = executeSql($sql);
		
		$data = array(
			'userInfo'=>$userInfo,
			'pages'=>$pager
			);
		
		$this->renderPartial('index',$data);

	}

	public function actionList($type = 'new', $page = 1){

        $this->render('list');

	}
	/*
	*获取推荐人数统计
	*/
	private function _userCount($uid){
		$sql = "SELECT COUNT(*) as num FROM {{user}} where reco_uid='".$uid."'";

		$nums = executeSql($sql);
		
		return $nums[0]['num'];
	}

	public function actionAjax(){

		if(Yii::app()->request->isAjaxRequest){
			$page =  (int)Yii::app()->request->getParam('page');
			$page = $page ? $page : 1;
		}

		$where = " 1=1 ";

		$order = 'ORDER BY u.uid DESC ';

		$start = ($page-1)* PAGE_NUMBER;

		if (Yii::app()->request->getParam('comefrom')) {
			$where .= " and comefrom = '".Yii::app()->request->getParam('comefrom')."'";
		}
		if (Yii::app()->request->getParam('starttime')) {
			$where .= " and login_start >= '".strtotime(Yii::app()->request->getParam('starttime'))."'";
		}
		if (Yii::app()->request->getParam('endtime')) {
			$where .= " and login_start <= '".strtotime(Yii::app()->request->getParam('endtime'))."'";
		}
		if (Yii::app()->request->getParam('rstarttime')) {
			$where .= " and reg_time >= '".strtotime(Yii::app()->request->getParam('rstarttime'))."'";
		}
		if (Yii::app()->request->getParam('rendtime')) {
			$where .= " and reg_time <= '".strtotime(Yii::app()->request->getParam('rendtime'))."'";
		}
		if (Yii::app()->request->getParam('username')) {
			$where .= " and username LIKE '%".mysqlLikeQuote(Yii::app()->request->getParam('username'))."%'";
		}
		if (Yii::app()->request->getParam('gid')) {
			$uid = User::model()->getUidByGid(Yii::app()->request->getParam('gid'));
			if ($uid) {
				$where .= " and uid = '".$uid."'";
			}
		}
		if (Yii::app()->request->getParam('nickname')) {
			$uid = User::model()->getUidByNickname(Yii::app()->request->getParam('nickname'));
			if ($uid) {
				$where .= " and uid = '".$uid."'";
			}
		}


		$sql = "SELECT IFNULL(f.nickname,u.username) as nickname,v.uid AS virtual, u.*,IF(u.gid >0,u.gid,u.uid) as gid FROM {{user}} u LEFT JOIN {{user_fields}} f ON f.uid = u.uid LEFT JOIN {{user_virtual}} v ON v.uid = u.uid  where ".$where.$order."limit "."$start,". PAGE_NUMBER;
		
		$userInfo = executeSql($sql);

		$sqlCount = "SELECT count(*) as num FROM {{user}} u LEFT JOIN {{user_fields}} f ON f.uid = u.uid LEFT JOIN {{user_virtual}} v ON v.uid = u.uid where ".$where;

		foreach ($userInfo as $k => $v) {

			$userInfo[$k]['isVirtul'] =  $v['virtual'] ? '':'<a href="" onClick="test('.$v['uid'].')">虚拟</a>';
			$userInfo[$k]['userCount'] =  $this->_userCount($v['uid']);
			$userInfo[$k]['reg_time'] = date('Y-m-d H:i:s',$v['reg_time']);
			$userInfo[$k]['last_login'] = date('Y-m-d H:i:s',$v['last_login']);
		}

		$pageCount = executeSql($sqlCount);

		$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);

		if($page > $pageCount) $page = $pageCount;

		$userInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$userInfo);
		
		echo CJSON::encode($userInfo);
	}
	/*
	*添加虚拟人
	*/
	public function actionAddVirtual(){
		$cri = new CDbCriteria();

		$VirtualModel = UserVirtual::model();
		
		$virtual = $VirtualModel->findAll($cri);
		
		$virtual = new UserVirtual();
		
		if(Yii::app()->request->isAjaxRequest){
		
			$virtual->uid =  (int)Yii::app()->request->getParam('uid');
		
			$virtual->username =  (int)Yii::app()->request->getParam('username');
			
			if ($virtual->save()) {
		
				echo CJSON::encode(array(1));
		
			}else{
		
				echo CJSON::encode(array(0));
		
			}
		}
	}
	//添加会员
	public function actionAdd(){
		
		$user = new User();

		if(Yii::app()->request->isAjaxRequest){
			
			$user->username = Yii::app()->request->getParam('username');
			$user->password = md5(Yii::app()->request->getParam('password'));
			$user->raw_pass = Yii::app()->request->getParam('password');
			$user->reg_time = time();
			$user->last_login = time();
			$user->reg_ip = userRealIp();
			$user->last_login_ip = userRealIp();

			if ($user->save()) {

				if (Yii::app()->request->getParam('virtual')) {
					
					$user = $user::model()->find(array(
					  'select' =>array('uid,username'),
					  'condition' => 'username='."'".Yii::app()->request->getParam('username')."'",
					));

					$virtual = new UserVirtual();
					$virtual->uid = $user['uid'];
					$virtual->username = $user['username'];
					$virtual->save();
				}
				echo CJSON::encode(array(3));

			}else{
				
				echo CJSON::encode(array(4));
			}
		}else{

			$this->render('add',array('userForm'=>$user));
		}	
		
	}
	public function actionTest(){

		$this->render('test');

	}
	//查询用户是否唯一
	public function actionUserUnique(){
		
		if(Yii::app()->request->isAjaxRequest){

			$username =  Yii::app()->request->getParam('username');

			$userModel = User::model();

			$user = $userModel::model()->find(array(
				  'select' =>array('username'),
				  'condition' => 'username='."'".$username."'",
				));
			
			if ($user) {

				echo CJSON::encode(array(1));

			}else{

				echo CJSON::encode(array(0));
			}
		}
		
	}
	public function actionVirtual(){

		$this->render('virtual');

	}
	public function actionVirtualList(){

		$where = " 1=1 ";

		if(Yii::app()->request->isAjaxRequest){
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('username')) {
				
				$where.= "and v.username like '%".trim(Yii::app()->request->getParam('username'))."%'";
			}

			if (Yii::app()->request->getParam('uid')) {

				$where.= "and v.uid = '".trim(Yii::app()->request->getParam('uid'))."'";

			}

		}
		
		$order = 'ORDER BY uid DESC ';
		
		$start = ($page-1)* PAGE_NUMBER;
		
		$sql = "SELECT v.uid, v.username,u.reg_time,u.last_login,u.last_login_ip,u.answer FROM {{user_virtual}} v LEFT JOIN {{user}} u ON v.uid = u.uid where ".$where.$order."limit "."$start,". PAGE_NUMBER;
		
		$virtualInfo = executeSql($sql);

		$sqlCount = "SELECT COUNT(*) as num FROM {{user_virtual}} v LEFT JOIN {{user}} u ON v.uid = u.uid where ".$where;
		
		$pageCount = executeSql($sqlCount);
		
		$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);

		foreach ($virtualInfo as $k => $v) {

			$virtualInfo[$k]['reg_time'] = date('Y-m-d H:i:s',$v['reg_time']);
			$virtualInfo[$k]['last_login'] = date('Y-m-d H:i:s',$v['last_login']);
			$virtualInfo[$k]['answer'] = '<span style="cursor:pointer;color:#0088cc" onClick="del('.$v['uid'].')">删除</span>';
		}

		if($page > $pageCount) $page = $pageCount;

		$virtualInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$virtualInfo);
		
		echo CJSON::encode($virtualInfo);
	}
	//删除虚拟人
	public function actionDelVirtual(){
		if(Yii::app()->request->isAjaxRequest){
			$virturlModel = UserVirtual::model();
			$del = $virturlModel->deleteByPk(Yii::app()->request->getParam('uid'));	
			if ($del) {
				echo CJSON::encode(array(1));
			}else{
				echo CJSON::encode(array(0));
			}
		}
	}
	//编辑昵称
	public function actionEditVirtual(){
		
		if(Yii::app()->request->isAjaxRequest){
			
			$virtual = new UserVirtual();

			if($virtual->updateByPk(Yii::app()->request->getParam('uid'), array('username'=>Yii::app()->request->getParam('username')))){
		
				echo CJSON::encode(array(1));

			}
		}
	}
	public function actionWatchman(){

		$this->render('watch');

	}
	public function actionWatchmanList(){
		
		$where = " 1=1 ";

		if(Yii::app()->request->isAjaxRequest){
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('username')) {
				
				$where.= "and u.username like '%".trim(Yii::app()->request->getParam('username'))."%'";
			}

			if (Yii::app()->request->getParam('uid')) {

				$where.= "and w.uid = '".trim(Yii::app()->request->getParam('uid'))."'";

			}

			$order = 'ORDER BY uid ASC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT u.uid,IFNULL(f.nickname,u.username) AS username,u.answer FROM {{room_watchman}} w LEFT JOIN {{user}} u ON u.uid = w.uid LEFT JOIN {{user_fields}} f ON f.uid = w.uid where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$virtualInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{room_watchman}} w LEFT JOIN {{user}} u ON u.uid = w.uid LEFT JOIN {{user_fields}} f ON f.uid = w.uid where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($virtualInfo as $k => $v) {

				$virtualInfo[$k]['gid']        = User::model()->getUserNicegid($v['uid']);
    			$virtualInfo[$k]['nickname']   = User::model()->getUserNick($v['uid']);

				$virtualInfo[$k]['answer'] = '<span style="cursor:pointer;color:#0088cc" onClick="del('.$v['uid'].')">删除</span>';
			}

			if($page > $pageCount) $page = $pageCount;

			$virtualInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$virtualInfo);
			
			echo CJSON::encode($virtualInfo);
		}

	}
	//删除虚拟人
	public function actionDelWatchman(){
		if(Yii::app()->request->isAjaxRequest){
			$watchmanModel = RoomWatchman::model();
			$del = $watchmanModel->deleteByPk(Yii::app()->request->getParam('uid'));	
			if ($del) {
				echo CJSON::encode(array(1));
			}else{
				echo CJSON::encode(array(0));
			}
		}
	}
	//添加训管
	public function actionAddWatchman(){

		$watchMan = new RoomWatchman();

		if(Yii::app()->request->isAjaxRequest){
			
			$watchMan->uid = Yii::app()->request->getParam('username');

			if ($watchMan->save()) {

				echo CJSON::encode(array(3));

			}else{
				
				echo CJSON::encode(array(4));
			}
		}else{
			$this->render('addwatchman',array('watchForm'=>$watchMan));
		}	
		
	}
	//判断训管帐号是否存在
	public function actionIsWatchMan(){
		
		if(Yii::app()->request->isAjaxRequest){

			$username =  Yii::app()->request->getParam('username');
			
			if ($this->_isWatch($username)) {

				echo CJSON::encode(array(2));

			}else{

				if ($username > GID_MAX_LENGHT && $username <= UID_MAX_LENGHT){// 如果靓号大于 9999999说明是UID 直接返回
		    		
		    		$uid = $this->_checkoutWatchMan('uid',$username);
		    		if ($uid) {
		    			echo CJSON::encode(array(1));
		    		}else{
		    			echo CJSON::encode(array(0));
		    		}
		    		
		    	}else{

		    		$uid = $this->_checkoutWatchMan('gid',$username);
		    		if ($uid) {
		    			if ($this->_checkoutWatchMan('uid',$uid)) {
			    			echo CJSON::encode(array(1));
			    		}else{
			    			echo CJSON::encode(array(0));
			    		}
		    		}else{
		    			echo CJSON::encode(array(0));
		    		}
		    	}
		    }	
		}
		
	}
	private function _checkoutWatchMan($uid,$username){

		$userModel = User::model();

		$user = $userModel::model()->find(array(
			  'select' =>array('uid'),
			  'condition' => ''.$uid.'='."'".$username."'",
		));
		return  $user['uid'] ? $user['uid']  : '';

	}
	private function _isWatch($username){
		$watchManModel = RoomWatchman::model();

		$watchMan = $watchManModel::model()->find(array(
			  'select' =>array('uid'),
			  'condition' => 'uid='."'".$username."'",
		));
		return  $watchMan['uid'] ? $watchMan['uid']  : '';
	}
	//验证名字长度
	public function actionCheckNameLen(){
		if (Yii::app()->request->isAjaxRequest) {
			echo CJSON::encode(array(nameLen(Yii::app()->request->getParam('username'))));
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
				'actions'=>array('list','add','watchman','ajax','addvirtual','userunique','delvirtual','virtuallist','virtual','index','watch','addwatchman','editvirtual','watchmanlist','delwatchman','iswatchman','checknamelen'),                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }
}
?>