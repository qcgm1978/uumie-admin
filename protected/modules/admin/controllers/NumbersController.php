<?php
/*
*号码模块
* author :zzh
*/
class NumbersController extends Controller{

	/*
	*号库管理
	*/
	public function actionIndex(){

		$this->render('index');
	
	}

	public function actionNumberList(){
		$page = 1;
		$where = "is_used = '0' ";

		if(Yii::app()->request->isAjaxRequest){
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;

			
			if (Yii::app()->request->getParam('gid')) {
				$where .= " and gid='".trim(Yii::app()->request->getParam('gid'))."'";
			}
			if (Yii::app()->request->getParam('mingid')) {
				$where .= " and gid >= '".trim(Yii::app()->request->getParam('mingid'))."'";
			}
			if (Yii::app()->request->getParam('maxgid')) {
				$where .= " and gid <= '".trim(Yii::app()->request->getParam('maxgid'))."'";
			}
				
			switch (Yii::app()->request->getParam('goodnum')) {
	            case 4:
	                $table = 'number_four';
	                break;
	            case 5:
	                $table = 'number_five';
	                break;
	            case 6:
	                $table = 'number_six';
	                break;
	            case 7:
	                $table = 'number_seven';
	                break;
	            default:
	                $table = 'number_four';
	                break;
		     }
			
			if (Yii::app()->request->getParam('uid')) {

				$where.= "and w.uid = '".trim(Yii::app()->request->getParam('uid'))."'";

			}
		$order = 'ORDER BY gid ASC ';
		
		$start = ($page-1)* PAGE_NUMBER;
		
		$sql = "SELECT * FROM {{".$table."}}  where ".$where.$order."limit "."$start,". PAGE_NUMBER;
		
		$numbers = executeSql($sql);

		$sqlCount = "SELECT count(*) as num FROM {{".$table."}}  where ".$where;
		
		$pageCount = executeSql($sqlCount);
		
		$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
		
		foreach ($numbers as $k => $v) {

			$numbers[$k]['is_used'] = $v['is_used'] ? '<span style ="color:#FF0000">已用</span>':'可用';
			$numbers[$k]['operat'] = '<input type="checkbox" name="demo" value="'.$v['gid'].'" />';
			$numbers[$k]['answer'] = '<a href="'.$this->createUrl("numbers/sales",array('gid'=>$v['gid'])).'">出售</a>';
		
		}

		if($page > $pageCount) $page = $pageCount;

		$numbers = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$numbers);
		
		echo CJSON::encode($numbers);	

		}
	}
	//出售号码
	public function actionSales(){
		
		if(Yii::app()->request->isAjaxRequest){
			
			$numberSale = new NumberSale();

			$gid = Yii::app()->request->getParam('gid');

			$gids = explode(',', $gid);

			$len = strlen($gids[0]);

			switch ($len) {

	            case 4:
	                $numberLib = new NumberFour();
	                break;

	            case 5:
	                $numberLib = new NumberFive();
	                break;

	            case 6:
	               $numberLib = new NumberSix();
	                break;

	            case 7:
	               $numberLib = new NumberSeven();
	                break;

	            default:
	               $numberLib = new NumberFour();
	                break;

		    }

			$price = Yii::app()->request->getParam('price');

			$remark = Yii::app()->request->getParam('remark');

			$count = 0;

			foreach ($gids as $k => $v) {
				
				$numberSale->gid = $v;
				$numberSale->gid_length = $len;
				$numberSale->sale_type = 1;
				$numberSale->sale_point = $price;
				$numberSale->gid_desc = $remark;

				if ($numberSale->save()) {

					if($numberLib->updateByPk($v, array('is_used'=>1))) $count++;

				}else{

					echo CJSON::encode(array(0));

				}
			}
			if ($count == count($gids)) {
				
				echo CJSON::encode(array(1));

			}else{
				echo CJSON::encode(array(0));
			}

		}else{

			$gid = $_REQUEST['gid']; 

			$this->render('sales',array('gid'=>$gid));
		}
		
	}
	public $goods = array(
		'4'=>'四位靓号',
		'5'=>'五位靓号',
		'6'=>'六位靓号',
		'7'=>'七位靓号'
		);
	/*
	*在售号码
	*/
	public function actionSaleInnum(){

		if(Yii::app()->request->isAjaxRequest){

			$where = " 1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('goodnum')) {

				$where .= $this->_lenNumber(Yii::app()->request->getParam('goodnum'));
				
			}
			
			if (Yii::app()->request->getParam('saleway')) {
				$where .= " and s.sale_type = '".Yii::app()->request->getParam('saleway')."'";
			}
			if (Yii::app()->request->getParam('gid')) {
				$where .= " and s.gid = '".trim(Yii::app()->request->getParam('gid'))."'";
			}
							
			
			$order = 'ORDER BY s.gid DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT s.gid,s.gid_length,s.sale_point,s.gid_desc, CASE s.sale_type  WHEN 1 THEN '金币' ELSE '积分' END AS sale_type FROM {{number_sale}} s   where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$numbers = executeSql($sql);

			$sqlCount = "SELECT count(*) as num FROM {{number_sale}}  s where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($numbers as $k => $v) {

				$numbers[$k]['gid_length'] = $this->goods[$v['gid_length']];
				
				$numbers[$k]['operat'] = '<input type="checkbox" name="demo" value="'.$v['gid'].'" />';
				$numbers[$k]['answer'] = '<a href="'.$this->createUrl("numbers/salesnum",array('gid'=>$v['gid'])).'">编辑</a> | <span style="cursor:pointer;color:#0088cc" onClick="shelves('.$v['gid'].')">下架</span>';
			
			}

			if($page > $pageCount) $page = $pageCount;

			$numbers = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$numbers);
			
			echo CJSON::encode($numbers);	

		}else{

			$this->render('saleinnum');

		}
	}
	public function actionSalesNum(){

		if(Yii::app()->request->isAjaxRequest){

			$numberSale = new NumberSale();

			if($numberSale->updateByPk(trim(Yii::app()->request->getParam('gid')), array('sale_point'=>trim(Yii::app()->request->getParam('price')),'gid_desc'=>trim(Yii::app()->request->getParam('remark')),'sale_type'=>trim(Yii::app()->request->getParam('salesway')),))){
		
				echo CJSON::encode(array(1));

			}else{

				echo CJSON::encode(array(0));
			}

		}else{

			$numberModel = NumberSale::model();
		
			$gid = $_REQUEST['gid'];
		
			$number = $numberModel::model()->find(array(
				  'select' =>array('*'),
				  'condition' => 'gid='."'".$gid."'",
				));
			
			$this->render('salesnum',array('number'=>$number));
		}
	}
	//下架
	public function actionShelves(){

		if(Yii::app()->request->isAjaxRequest){

			$gid = Yii::app()->request->getParam('gid');
			
			$gid = "(".$gid.")";

			if (NumberSale::model()->deleteAll('gid in '.$gid)) {
				
				$gids = explode(',', Yii::app()->request->getParam('gid'));
				
				$count = 0;

				foreach ($gids as $v) {

					if ($this->_updateMumber($v,0)) {

						$count++;
					
					}
				}
				if ($count==count($gids)) {

					echo CJSON::encode(array(1));
				}

			}else{

				echo CJSON::encode(array(0));

			}
		}
	}
	private function _updateMumber($gid,$status){

		switch (strlen(trim($gid))) {

	            case 4:
	                $numberLib = new NumberFour();
	                break;

	            case 5:
	                $numberLib = new NumberFive();
	                break;

	            case 6:
	               $numberLib = new NumberSix();
	                break;

	            case 7:
	               $numberLib = new NumberSeven();
	                break;

	            default:
	               $numberLib = new NumberFour();
	                break;

		    }
		    if($numberLib->updateByPk($gid, array('is_used'=>$status))){
		    	return 1;
		    }else{
		    	return 0;
		    }
	}
	private function _lenNumber($len){

		switch ($len) {
			case '4':
				$where = " and s.gid_length = '4' ";
				break;
			case '5':
				$where = " and s.gid_length = '5' ";
				break;
			case '6':
				$where = " and s.gid_length = '6' ";
				break;
			default:
				$where = " and s.gid_length = '7' ";
				break;
		}

		return $where;
	}
	//已售号码
	public function actionNumSold(){

		if (Yii::app()->request->isAjaxRequest){
			$where = " 1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('goodnum')) {

				$where .= $this->_lenNumber(Yii::app()->request->getParam('goodnum'));
				
			}
			
			if (Yii::app()->request->getParam('allgid')) {
				
				$allgid = $this->_allGid(Yii::app()->request->getParam('gid'));

				if ($allgid) {

					$where .= " and s.uid = '".$allgid."'";
				}

			}

			if (Yii::app()->request->getParam('saleway')) {
				$where .= " and s.sale_type = '".Yii::app()->request->getParam('saleway')."'";
			}

			if (Yii::app()->request->getParam('gid')) {
				$where .= " and s.gid = '".trim(Yii::app()->request->getParam('gid'))."'";
			}							
			
			$order = 'ORDER BY s.gid DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT s.gid,s.gid_length,s.sale_point, FROM_UNIXTIME(sale_time,'%Y-%m-%d %H:%i:%s') AS
	sale_time, CASE s.sale_type WHEN 1 THEN '金币'  WHEN 3 THEN '赠送' WHEN 4 THEN '分配' ELSE '积分' END AS sale_type, IFNULL(f.nickname,u.username) as nickname FROM {{number_sold}} s LEFT JOIN {{user_fields}} f ON f.uid=s.uid  LEFT JOIN {{user}} u ON u.uid=s.uid  where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			// var_dump($sql);exit();
			$numberSold = executeSql($sql);

			$sqlCount = "SELECT count(*) as num FROM {{number_sold}} s where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($numberSold as $k => $v) {

				$numberSold[$k]['gid_length'] = $this->goods[$v['gid_length']];
				
			}

			if($page > $pageCount) $page = $pageCount;

			$numberSold = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$numberSold);
			
			echo CJSON::encode($numberSold);

		}else{
			
			$this->render('numsold');
		}
		
	}
	private function _allGid($gid){

		$userModel = User::model();

		if ($gid > GID_MAX_LENGHT && $gid <= UID_MAX_LENGHT){// 如果靓号大于 9999999说明是UID 直接返回
			$user = $userModel::model()->find(array(
			  'select' =>array('uid'),
			  'condition' => 'uid='."'".$gid."'",
			));

    		if($user)
    		{
    			return $gid;
    		}else{	   		
	   			return '';
    		}
    	}else{

    		$user = $userModel::model()->find(array(
			  'select' =>array('uid'),
			  'condition' => 'gid='."'".$gid."'",
			));

			return $user['uid'];
    		
    	}

	}
	//分配号码
	public function actionAssignnum(){

		// $articles = UserAccount::model()->changeCoin('320120339',-20);
		// var_dump($articles);exit();

		if (Yii::app()->request->isAjaxRequest) {

			$type = Yii::app()->request->getParam('operatype');
			$gid = Yii::app()->request->getParam('gid');
			$assignid = Yii::app()->request->getParam('assignid');
			$choiceid = Yii::app()->request->getParam('choiceid');
			$rid = Yii::app()->request->getParam('rid');
			
			$uid = $this->_allGid($gid);

			if ($type == 1 && $choiceid > 0){

				if ($choiceid > UserAccount::model()->checkCoin($uid)){

					echo CJSON::encode(array(0));

				}else{

					UserAccount::model()->changeCoin($uid, $choiceid *-1);
				}
				
			}else if ($type == 2 && $choiceid > 0) {

				if ($choiceid > UserAccount::model()->checkIntegral($uid)){

					echo CJSON::encode(array(1));

				}else{

					UserAccount::model()->changeIntegral($uid, $choiceid *-1);
				}

			}else if ($type == 3 && $choiceid > 0) {

					UserAccount::model()->changeIntegral($uid, $choiceid);


			}else{

				$choiceid = 0;

			}

			$this->_updateMumber($assignid,1);

			UserAccount::model()->giveGid($assignid, strlen($assignid), $type, $choiceid, $uid);

			if ($rid) {

				UserAccount::model()->useGid($assignid, $uid);
			}

			echo CJSON::encode(array(100));
			
		}else{
			
			$this->render('assignnum');

		}
	
	}
	//检查用户号码是否存在
	public function actionCheckNum(){

		if (Yii::app()->request->isAjaxRequest) {

			$uid = Yii::app()->request->getParam('uid');

			$user = $this->_allGid($uid);

			if (!$user || !$this->_checkUser($user)) {
				
				echo CJSON::encode(array(0));

			}else{

				echo CJSON::encode(array(1));
			}
		}
	}
	private function _checkUser($uid){

		$user = User::model()->find(array(
			  'select' =>array('uid'),
			  'condition' => 'uid='."'".$uid."'",
			));

		return $user['uid'];
	}
	//检查分配号码是否存在
	public function actionCheckAssign(){

		if (Yii::app()->request->isAjaxRequest) {

			$uid = Yii::app()->request->getParam('uid');

			if (strlen(trim($uid)) < 8 && $this->_gidSold($uid) == 1) {
	            
	            echo CJSON::encode(array(3));

	        }else{

	            echo CJSON::encode(array(4));

	        }
		}
	}
	private function _gidSold($uid){

		$user = NumberSold::model()->find(array(
			  'select' =>array('gid'),
			  'condition' => 'gid='."'".$uid."'",
			));
		
		return $user ? 1 : 0;
	}
	public function actionRecover(){

		if (Yii::app()->request->isAjaxRequest) {
			
			$gid = Yii::app()->request->getParam('gid');

			if($gid){

				User::model()->updateByPk($gid, array('gid'=>0));

				NumberSold::model()->deleteByPk($gid);

				$this->_updateMumber($gid,0);
				
				echo CJSON::encode(array(1));

			}else{

				echo CJSON::encode(array(0));
			}

		}else{

			$this->render('recover');
		}		
	}
	function filters() {
        return array(
            'accessControl',
        );
    }
    
    function accessRules() {
        return array(
            array(
                'allow',
				'actions'=>array('index','numberlist','sales','saleinnum','shelves','salesnum','checkassign','checknum','numsold','assignnum','recover'),                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }
	

}