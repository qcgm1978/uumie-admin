<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
**系统优化
*/
class SystemsetController extends Controller{
	
	/*
	* 管理员日志
	*/
	
	public function actionServer(){
		
		if (Yii::app()->request->isAjaxRequest) {

			$where = " 1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			
			if (Yii::app()->request->getParam('carname')) {
				$where .= " AND name LIKE '%'".trim(Yii::app()->request->getParam('carname'))."'";
			}
						
			
			$order = 'ORDER BY id ASC ';
			
			
			$sql = "SELECT  * FROM {{room_server}} ".$order; 			

			$serverInfo = executeSql($sql);

			foreach ($serverInfo as $k => $v) {

				$serverInfo[$k]['rooms'] = Room::model()->getRoomsCount($v['id']);
				$serverInfo[$k]['operate'] = '<a href="'.$this->createUrl("systemset/add",array('sid'=>$v['id'])).'">编辑</a> | <span style="cursor:pointer;color:#0088cc" onClick="del('.$v['id'].')">删除</span>';
			}

			echo CJSON::encode($serverInfo);
			
		}else{

			$this->render('server');	
		}
	}
	public function actionAdd(){

		if (Yii::app()->request->isAjaxRequest) {
			$systemSet = new RoomServer();
			$systemSet->id = rand(1000,9999);
			$systemSet->number = $data['number'] = Yii::app()->request->getParam('sid');
			$systemSet->type = $data['type'] =  Yii::app()->request->getParam('snet');
			$systemSet->name = $data['name'] = Yii::app()->request->getParam('sname');
			$systemSet->host = $data['host'] = Yii::app()->request->getParam('sip');
			$systemSet->port = $data['port'] = Yii::app()->request->getParam('sport');
			$systemSet->host2 = $data['host2'] = Yii::app()->request->getParam('sips');
			$systemSet->port2 = $data['port2'] = Yii::app()->request->getParam('sports');
			$sids = Yii::app()->request->getParam('sids');
			if ($sids) {
				if (RoomServer::model()->updateByPk($sids,$data)) {
					echo CJSON::encode(array(2));
				}else{
					echo CJSON::encode(array(3));
				}

				
			}else{
				if ($systemSet->save()) {
					echo CJSON::encode(array(1));
				}else{
					echo CJSON::encode(array(0));
				}
			}

			

		}else{
			$sid = $_REQUEST['sid'];
			$sInfo = RoomServer::model()->getServerInfo($sid);
			// p($giftInfo);
			$data = array(
				'sid'=>$sInfo['id'],
				'snumber'=>$sInfo['number'],
				'sname'=>$sInfo['name'],
				'snet'=>$sInfo['type'],
				'sip'=>$sInfo['host'],
				'sport'=>$sInfo['port'],
				'sips'=>$sInfo['host2'],
				'sports'=>$sInfo['port2'],

				);

			$this->render('add',$data);
		}
	}
	public function actionCheksid(){
		
		if (Yii::app()->request->isAjaxRequest) {
			$sid = Yii::app()->request->getParam('sid');
			$snets = Yii::app()->request->getParam('snets');
			if (RoomServer::model()->getSid($sid,$snets)) {
				echo CJSON::encode(array(1));
			}else{
				echo CJSON::encode(array(0));
			}
		}
	}
	//删除服务器
	public function actionDel(){
		if (Yii::app()->request->isAjaxRequest) {

			if (RoomServer::model()->deleteByPk(Yii::app()->request->getParam('sid'))) {
				echo CJSON::encode(array(2));
			}else{
				echo CJSON::encode(array(0));
			}
		}
	}
	//词语屏蔽
	public function actionWord(){
		if (Yii::app()->request->isAjaxRequest) {
			
			$str = Yii::app()->request->getParam('word') ? trim(Yii::app()->request->getParam('word')):'';
			
			for ($i=0; $i<strlen($str); $i++){
		    	
		    	if ($str{0} == '|'){
		    		
		    		$str = substr($str, 1, strlen($str));

		    	}else if($str{strlen($str)-1} == '|'){
		    	
		    		$word = substr($word, 0, strlen($word)-1);
		    	
		    	}else{
		    		break;
		    	}
    		}

			if (CommonData::model()->updateByPk(Yii::app()->request->getParam('id'),array('data'=>$str))) {
				
				echo CJSON::encode(array(1));
			}else{
				
				echo CJSON::encode(array(0));
			}

		}else{

			$word = CommonData::model()->getWordBanned('word_banned');

			$this->render('word',array('word'=>$word));
		}

	}
	//系统设置
	public function actionSyset(){
		// echo phpinfo();
		if (Yii::app()->request->isAjaxRequest) {
			$param = Yii::app()->request->getParam('param');
			// p($param);
			$count = 0;
			foreach ($param as $k => $v) {
				if ($v['value']) {
					$sql = "update {{config}} set value='".$v['value']."' where type <> 'hidden' and code ='".$v['name']."'";

					if (Yii::app()->db->createCommand($sql)->execute()){
						$count ++;
					}
					
				}

			}
			if ($count >0) {
				echo CJSON::encode(array(1));
			}else{
				echo CJSON::encode(array(0));
			}
			
			
		}else{
			$where = " parent_id!=0";
			$sql = "SELECT id,code,value FROM {{config}} WHERE ".$where; 			

			$sysInfo = executeSql($sql);

			$where = " type ='hidden' and parent_id!=0";
			$sqls = "SELECT id FROM {{config}} WHERE ".$where; 			

			$idInfo = executeSql($sqls);
			$param = '';
			foreach ($idInfo as $key => $value) {
				if ($key==count($idInfo)-1) {
					$param .= $value['id'];
				}else{
					$param .= $value['id'].',';
				}
				
			}
			$data['param'] = $param;
			foreach ($sysInfo as $v) {
				$data[$v['code']] = $v['id'].'_'.$v['value'];
			}
			// p($data);

			$this->render('syset',$data);
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
                'actions'=>array('server','add','word','syset','cheksid','del'),
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