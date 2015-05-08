<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
*房间模块
* author :zzh
*/
class RoomController extends Controller{

	/*
	*房间列表
	*/
	public function actionList(){

		if (Yii::app()->request->isAjaxRequest) {
			
			$where = " 1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('goodnum')) {

				$where .= $this->_lenNumber(Yii::app()->request->getParam('goodnum'));
				
			}
			
			if (Yii::app()->request->getParam('saleway')) {
				$where .= " and sale_type = '".Yii::app()->request->getParam('saleway')."'";
			}
			if (Yii::app()->request->getParam('gid')) {
				$where .= " and gid = '".trim(Yii::app()->request->getParam('gid'))."'";
			}
							
			
			$order = 'ORDER BY r.sort_order DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT r.*, s. NAME AS room_server,s.host2 as room_owner, s.host2 as room_owner_gid, rl.create_time AS starttime FROM {{room}} r LEFT JOIN {{room_server}} s ON s.id = r.server_id LEFT JOIN {{room_live}} rl ON rl.room_id = r.room_id where ".$where.$order."limit "."$start,". PAGE_NUMBER; 			

			$numbers =executeSql($sql);

			$sqlCount = "SELECT COUNT(*) AS num FROM {{room}} r LEFT JOIN {{room_server}} s ON s.id = r.server_id LEFT JOIN {{room_live}} rl ON rl.room_id = r.room_id  where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			$infos = array('room_owner'=>'','room_owner_gid'=>'');
			foreach ($numbers as $k => $v) {
				// var_dump($v);exit();
				$numbers[$k]['room_name'] = '<span title="点击修改">'.$v['room_name'].'</span>';
				$numbers[$k]['max_user'] = '<span title="点击修改">'.$v['max_user'].'</span>';
				$numbers[$k]['sort_order'] = '<span title="点击修改">'.$v['sort_order'].'</span>';
				$numbers[$k]['room_owner'] = $this->_roomOwnerGid($v['room_id'],'room_owner');
				$numbers[$k]['room_owner_gid'] = $this->_roomOwnerGid($v['room_id'],'room_owner_gid');
				$numbers[$k]['starttime'] = $v['starttime'] ? '直播中':'未直播';			
				$numbers[$k]['operat'] = '<input type="checkbox" name="demo" value="'.$v['room_id'].'" />';
				$numbers[$k]['answer'] = '<a href="'.$this->createUrl("room/virtualuser",array('roomid'=>$v['room_id'],'roomname'=>$v['room_name'])).'">加入</a> | <a href="'.$this->createUrl("room/addroom",array('roomid'=>$v['room_id'])).'">编辑</a> | <span style="cursor:pointer;color:#0088cc" onClick="recommed('.$v['room_id'].',4,4'.')">删除</span>';

				$numbers[$k]['is_recommend'] = $v['is_recommend'] ? '<span style="cursor:pointer" onClick="recommed('.$v['room_id'].',0,1'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="recommed('.$v['room_id'].',1,1'.')"><i class="icon-remove"></i></span>';
				$numbers[$k]['is_lock'] = $v['is_lock'] ? '<span style="cursor:pointer" onClick="recommed('.$v['room_id'].',0,2'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="recommed('.$v['room_id'].',1,2'.')"><i class="icon-remove"></i></span>';
				$numbers[$k]['is_hidden'] = $v['is_hidden'] ? '<span style="cursor:pointer" onClick="recommed('.$v['room_id'].',0,3'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="recommed('.$v['room_id'].',1,3'.')"><i class="icon-remove"></i></span>';
			}

			if($page > $pageCount) $page = $pageCount;

			$numbers = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$numbers);
			
			echo CJSON::encode($numbers);	


		}else{

			$info = $this->_seCat($this->_catOptions(RoomCategory::model()->catList(0, 0, false, 0, true, false)));
		
			$this->render('list',array('info'=>$info));
		}
	}
	private function _roomOwnerGid($roomid,$param){
		$sql = "select u.username AS room_owner,u.gid AS room_owner_gid from {{room_limits}} l  left join {{user}} u ON u.uid = l.uid where l.type=1 and l.room_id='".$roomid."'";
		// var_dump($sql);exit();
		$result = array();
		$infos =executeSql($sql);
		
		foreach ($infos as $key => $value) {
			$result = $value[$param];
		}

		return $result;
	}

	//更新房间 推荐、隐藏、关闭状态
	public function actionUpdateInfo(){
		if (Yii::app()->request->isAjaxRequest) {

			$roomid = Yii::app()->request->getParam('roomid');
			$status = Yii::app()->request->getParam('status');
			$type = Yii::app()->request->getParam('type');

			$roomid = "(".$roomid.")";
			// echo $roomid;exit();
			switch ($type) {
				
				case '1':
					$data = array('is_recommend'=>$status);
					break;
				case '2':
					$data = array('is_lock'=>$status);
					break;
				case '3':
					$data = array('is_hidden'=>$status);
					break;
				case '5':
					$data = array('room_name'=>$status);
					break;
				case '6':
					$data = array('max_user'=>$status);
					break;
				case '7':
					$data = array('sort_order'=>$status);
					break;								
			}
			if ($type == 4) {
				
				if (Room::model()->deleteAll('room_id in '.$roomid)) {

					echo CJSON::encode(array(2));

				}

			}else{
				
				if (Room::model()->updateAll($data,'room_id in'.$roomid)) {

					echo CJSON::encode(array(1));

				}else{

					echo CJSON::encode(array(0));
				}
			}
			
		}

	}
	//房间虚拟人
	public function actionVirtualUser($roomid,$roomname){

		
		$virtual = Room::model()->find(array(
			  'select' =>array('no_guest'),
			  'condition' => 'room_id='."'".$roomid."'",
			));

		$this->render('virtualuser',array('roomid'=>$roomid,'roomname'=>$roomname,'virtual'=>$virtual['no_guest']));
	}
	public function actionAddVirtual(){

		// if (Yii::app()->request->isAjaxRequest) {

			$time = Yii::app()->request->getParam('time');
			$virtualguest = Yii::app()->request->getParam('virtualguest');
			$virtualuser = Yii::app()->request->getParam('virtualuser');
			$roomid = Yii::app()->request->getParam('roomid');
			$roomname = Yii::app()->request->getParam('roomname');
			
			$room = Room::model()->find(array(
			  'select' =>array('room_name'),
			  'condition' => 'room_id='."'".$roomid."'",
			));
			if ($room) {

				makeVirusersList('201882', 3, 1, 0);

			}else{

				echo CJSON::encode(array(0));
			}

			
			
		// }
	}
	/*
	*房间类别
	*/
	public function actionClassify(){
		
		if (Yii::app()->request->isAjaxRequest) {

			# code...
		}else{
			// p(RoomCategory::model()->catList(0, 0, false, 0, true, false));exit();
			$result = $this->_catOptions(RoomCategory::model()->catList(0, 0, false, 0, true, false));
			// p($result);exit();
			$this->render('classify',$result);
		}
	}

	public function actionEdit($catid){

				
		$info = $this->_seCat($this->_catOptions(RoomCategory::model()->catList(0, 0, false, 0, true, false)));
		
		$this->render('edit',array('info'=>$info,'chioce'=>$info[$catid]));
		
	}
	public function actionAdd(){

		$info = $this->_seCat($this->_catOptions(RoomCategory::model()->catList(0, 0, false, 0, true, false)));
		
		$this->render('add',array('info'=>$info));
	}
	//保存房间分类
	public function actionSave(){

		if (Yii::app()->request->isAjaxRequest) {

			$catid = Yii::app()->request->getParam('catid');

			if ($catid) {

				$data = array(
					'cat_name'=>Yii::app()->request->getParam('catname'),
					'parent_id'=>Yii::app()->request->getParam('catype'),
					'is_show'=>Yii::app()->request->getParam('show'),
					'link_url'=>Yii::app()->request->getParam('sUrl'),
					'sort_order'=>Yii::app()->request->getParam('sortorder'),
					);

				if (RoomCategory::model()->updateByPk($catid, $data)) {
					echo CJSON::encode(array(1));
				}else{
					echo CJSON::encode(array(0));
				}

			}else{
				
				$roomCategpry = new RoomCategory();

				$roomCategpry->cat_name = Yii::app()->request->getParam('catname');
				$roomCategpry->parent_id = Yii::app()->request->getParam('catype');
				$roomCategpry->is_show = Yii::app()->request->getParam('show');
				$roomCategpry->link_url = Yii::app()->request->getParam('sUrl');
				$roomCategpry->sort_order = Yii::app()->request->getParam('sortorder');
				
				if ($roomCategpry->save()) {
					echo CJSON::encode(array(1));
				}else{
					echo CJSON::encode(array(0));
				}

			}
			
			
		}

	}
	//删除房间分类
	public function actionDel(){

		if (Yii::app()->request->isAjaxRequest) {

			if (RoomCategory::model()->deleteByPk(Yii::app()->request->getParam('catid'))) {

				$url = $this->createUrl('room/classify');
				echo $url;
				header("Location:".$url."");

			}else{
				
				echo CJSON::encode(array(0));
			}

		}

	}
	private function _seCat($result){
		
		$info = array();

		foreach ($result['parent'] as $k => $v) {
				$info[$v['cat_id']] = $v;		
				foreach ($result['child']  as $key => $value) {
					if ($v['cat_id'] == $value['parent_id']) {
						$value['cat_name'] ='&nbsp;&nbsp;&nbsp;&nbsp;'.$value['cat_name'];
						$info[$value['cat_id']] = $value;	
					}
				}
			}
			return $info;
	}
	private function _catOptions($arr) {

		$cat_options = $data = $cat_child = array();

		foreach ($arr as $k => $v) {
			if ($v['parent_id'] == 0) {

				$cat_options[$k]['cat_id'] = $v['cat_id'];
				$cat_options[$k]['cat_name'] = $v['cat_name'];
				$cat_options[$k]['parent_id'] = $v['parent_id'];
				$cat_options[$k]['is_show'] = $v['is_show'] ? '显示':'不显示';
				$cat_options[$k]['sort_order'] = $v['sort_order'];
				$cat_options[$k]['link_url'] = $v['link_url'];
				$cat_options[$k]['has_children'] = $v['has_children'];
				$cat_options[$k]['child'] = $v['child'];
				$cat_options[$k]['opera'] = '<a href="'.$this->createUrl("room/edit",array('catid'=>$v['cat_id'])).'">编辑</a>|<a onClick="del('.$v['cat_id'].')">删除</a>';
			}else{																	

				$cat_child[$k]['cat_id'] = $v['cat_id'];
				$cat_child[$k]['cat_name'] = $v['cat_name'];
				$cat_child[$k]['parent_id'] = $v['parent_id'];
				$cat_child[$k]['is_show'] = $v['is_show'] ? '显示':'不显示';
				$cat_child[$k]['sort_order'] = $v['sort_order'];
				$cat_child[$k]['link_url'] = $v['link_url'];
				$cat_child[$k]['has_children'] = $v['has_children'];
				$cat_child[$k]['opera'] = '<a href="'.$this->createUrl("room/edit",array('catid'=>$v['cat_id'])).'">编辑</a>|<a onClick="del('.$v['cat_id'].')">删除</a>';
			}
		}
		$data['parent'] = $cat_options;
		$data['child'] = $cat_child;

		return $data;
		
	}
	//添加房间和编辑房间
	public function actionAddRoom(){
		if (Yii::app()->request->isAjaxRequest) {
			$param = Yii::app()->request->getParam('param');
			$roomid = Yii::app()->request->getParam('roomid');

			foreach ($param as $key => $value) {
				if(!empty($value['value'])){
					$info[$value['name']] = $value['value'];
				}
				if (strstr($value['name'],'othercat')) {
				 	$othercat[]=$value['value'];
				 } 
			}
			$room = new Room();
			$room->room_name = $data['room_name'] = trim($info['room_name']);
			$room->cat_id = $data['cat_id'] =intval($info['room_cat']);
			$room->server_id = $data['server_id'] =intval($info['room_server']);
			$room->password = $data['password'] =$info['room_password'] ? trim($info['room_name']) : '';
			$room->bitrate = $data['bitrate'] =$info['bitrate'] ? intval($info['bitrate']) : 150;
			$room->max_user = $data['max_user'] =$info['max_user'] ? intval($info['max_user']) : Config::model()->getScale('room_min_user');
			$room->room_type = $data['room_type'] =$info['room_type'] ? intval($info['room_type']) : 1;
			$room->agency_uid = $data['agency_uid'] =$info['agency_uid'] ? intval($info['agency_uid']) : 0;
			$room->network = $data['network'] =RoomServer::model()->getServerType(intval($info['room_server']));
			$room->create_time = time();

			$roomFileds = new RoomFields();
			$roomFileds->icon = $fdata['icon'] = $info['room_icon'];
			$roomFileds->welcome = $fdata['welcome'] = $info['room_welcome'] ? trim($info['room_welcome']) :'';
			$roomFileds->video1 = $fdata['video1'] = $info['room_video1'] ? ($info['room_video1']) :0;
			$roomFileds->video2 = $fdata['video2'] = $info['room_video2'] ? ($info['room_video2']) :0;
			$roomFileds->video3 = $fdata['video3'] = $info['room_video3'] ? ($info['room_video3']) :0;

			if ($roomid) {
				$count = 0;
				if (Room::model()->updateByPk($roomid,$data)) {
					$count ++;
				}
				if ($info['room_owner']) {
					$roomOwnerName = User::model()->checkUsername ($info['room_owner']);

					if ($roomOwnerName) {
						$roomOwnerUid = User::model()->getUidByUsername($roomOwnerName);
						
						RoomLimits::model()->updateRoomOwner($roomid,$roomOwnerUid);

					}else{
						RoomLimits::model()->deleteByPk($roomid);
					}
				}
				if (!empty($othercat)) {
					RoomCategoryOther::model()->handleOtherCat($roomid,array_unique($othercat));
				}
				if (RoomFields::model()->updateByPk($roomid,$fdata)) {
					$count ++;
				}
				// p($count);exit();
				if ($count) {
					echo CJSON::encode(array(2));
				}else{
					echo CJSON::encode(array(3));
				}
				
			}else{
				if ($room->save()) {
					$roomid = $room->attributes['room_id'];
					if ($info['room_owner']) {
						$roomOwnerName = User::model()->checkUsername ($info['room_owner']);
						if ($roomOwnerName) {
							$roomOwnerUid = User::model()->getUidByUsername($roomOwnerName);
							RoomLimits::model()->addRoomOwner($roomid,$roomOwnerUid);
						}
					}
					$roomFileds->room_id = $roomid;

					if (!empty($othercat)) {
						RoomCategoryOther::model()->handleOtherCat($roomid,array_unique($othercat));
					}

					if ($roomFileds->save()) {
						echo CJSON::encode(array(1));
					}else{
						echo CJSON::encode(array(0));
					}
				}
			}
			
		}else{
			$roomInfo = Room::model()->getRoomInfo($_REQUEST['roomid']);
			$roomFieldsInfo = RoomFields::model()->getRoomFieldsInfo($_REQUEST['roomid']);
			// p($roomInfo);exit();
			$info = $this->_seCat($this->_catOptions(RoomCategory::model()->catList(0, 0, false, 0, true, false)));
			$serverList = RoomServer::model()->serverList(0, true);
			$agencyList = Agency::model()->agencyList(0, true);
			$roomlimitb = Room::model()->getRoomManager($_REQUEST['roomid'],2);
			$roomlimitc = Room::model()->getRoomManager($_REQUEST['roomid']);
			$data = array(
				'roomid'=>$roomInfo['room_id'],
				'roomname'=>$roomInfo['room_name'],
				'catid'=>$roomInfo['cat_id'],
				'agencyuid'=>$roomInfo['agency_uid'],
				'serverid'=>$roomInfo['server_id'],
				'bitrate'=>$roomInfo['bitrate'],
				'maxuser'=>$roomInfo['max_user'],
				'password'=>$roomInfo['password'],
				'welcome'=>$roomFieldsInfo['welcome'],
				'icon'=>$roomFieldsInfo['icon'],
				'video1'=>$roomFieldsInfo['video1'],
				'video2'=>$roomFieldsInfo['video2'],
				'video3'=>$roomFieldsInfo['video3'],
				'info'=>$info,
				'serverList'=>$serverList,
				'agencyList'=>$agencyList,
				'roomlimitb'=>$roomlimitb,
				'roomlimitc'=>$roomlimitc,
				'roomowner'=>Room::model()->getRoomOwner($roomInfo['room_id'])
			);
			// p($data);exit();
			$this->render('addroom',$data);
		}
	}
	
	//判断房间是否存在
	public function actionRoomNameExists(){
		
		if (Yii::app()->request->isAjaxRequest) {
			$name = trim(Yii::app()->request->getParam('name'));
			$roomid = Yii::app()->request->getParam('roomid');
			 // 房间名称长度
		    if(strlen($name) > 30){
		    	echo CJSON::encode(array(0));
		    }
			if (Room::model()->roomNameExists($name,$roomid)) {
				echo CJSON::encode(array(1));	
			}

		}

	}
	public function actionGetCat(){

		$info = $this->_seCat($this->_catOptions(RoomCategory::model()->catList(0, 0, false, 0, true, false)));
		
		$str = '<select name="othercat'.rand(0,15).'"><option value="0">请选择</option>';
		foreach ($info as $key => $value) {
			$str.='<option value="'.$value['cat_id'].'">'.$value['cat_name'].'</option>';		
		}
		$str.='</select>&nbsp;&nbsp;';
		echo CJSON::encode(array($str));	

	}
	public function filters() {
        return array(
            'accessControl',
        );
    }
    
    function accessRules() {
        return array(
            array(
                'allow',
                'actions'=>array('list','virtualuser','addvirtual','classify','updateinfo','edit','add','addroom','getcat','save','del','roomnameExists'),
                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }
	
}