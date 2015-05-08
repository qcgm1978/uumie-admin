<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");

class MonitorController extends Controller{

    public function init(){

        define('IMG_URL',Yii::getPathOfAlias('webroot')."/upload/screenshot/");
    }
	/*
	*实时监控
	*/
	public function actionIndex(){

        if (Yii::app()->request->getParam('time')) {
            $where = " and rl.create_time >='".Yii::app()->request->getParam('time')."'";
        }

		$sql = "select rl.*,u.username,f.family_name from {{room_live}} rl LEFT JOIN {{user}} u ON u.uid=rl.uid LEFT JOIN {{family_limits}} fl ON fl.uid=rl.uid LEFT JOIN {{family}} f ON f.family_id=fl.family_id  WHERE 1=1 ".$where;
		$data = executeSql($sql);

        foreach ($data as $k => $v) {
            $v['room_id'];
		    $imgurl = IMG_PATH.'201803'."/".date('Ymd',$v['create_time'])."/";
			$url = IMG_URL.'201803'."/".date('Ymd',$v['create_time'])."/";
			$img = $this->_getFile($url);
			
			$data[$k]['img'] =$imgurl.$img[0] ;
		}

        if($where){

            echo CJSON::encode($data);

        }else{

            $this->render('index',array('info'=>$data,'aid'=>$_SESSION['uid']));
        }

	}
	public function actionMinIndex(){

        $sql = "select rl.*,u.username,f.family_name from {{room_live}} rl LEFT JOIN {{user}} u ON u.uid=rl.uid LEFT JOIN {{family_limits}} fl ON fl.uid=rl.uid LEFT JOIN {{family}} f ON f.family_id=fl.family_id ";
		$data = executeSql($sql);

        foreach ($data as $k => $v) {
            $v['room_id'];
		    $imgurl = IMG_PATH;
			$url = IMG_URL.'201803'."/".date('Ymd',$v['create_time'])."/";
			echo $imgurl;
			$img = $this->_getDir($imgurl);
			p($img);exit();
			$data[$k]['img'] =$imgurl.$img[0] ;
		}

        $this->render('index',array('info'=>$data));
	}

    //获取所有文件目录
	private function _getDir($dir) {

	    $dirArray[]=NULL;

        if (false != ($handle = opendir ( $dir ))) {
	        $i=0;
	        while ( false !== ($file = readdir ( $handle )) ) {
	            //去掉"“.”、“..”以及带“.xxx”后缀的文件
	            if ($file != "." && $file != ".."&&!strpos($file,".")) {
	                $dirArray[$i]=$file;
	                $i++;
	            }
	        }
	        //关闭句柄
	        closedir ( $handle );
	    }
	    return $dirArray;
	}
    //获取所有文件返回为文件夹

	private function _getFile($dir) {

	    $fileArray[]=NULL;
	    if (false != ($handle = opendir ( $dir ))) {
	        $i=0;
	        while ( false !== ($file = readdir ( $handle )) ) {
	            //去掉"“.”、“..”以及带“.xxx”后缀的文件
	            if ($file != "." && $file != ".."&&strpos($file,".")) {
	                $fileArray[$i]=$file;
	                
	                $i++;
	            }
	        }
	        //关闭句柄
	        closedir ( $handle );
	    }
	    return $fileArray;
	}

    //查看房间是否关闭
	public function actionCheckRoomLive(){

		if (Yii::app()->request->isAjaxRequest) {

				echo CJSON::encode(array(RoomLive::model()->checkRoomLive(Yii::app()->request->getParam('roomid'))));
		}
	}

	//系统自动记录管理
	public function actionSystemRecord(){
		$page = 1;
		if (Yii::app()->request->getParam('uid')) {
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			$where = " and uid='".Yii::app()->request->getParam('uid')."'";
		}

		$page = $_REQUEST['page'] ? $_REQUEST['page'] :$page;
		$order = 'ORDER BY uid ASC ';
		$pageNum = 40;
		$start = ($page-1)* $pageNum;
		$sqlCount = "SELECT count(*) as num FROM {{user_fields}} where 1=1 ".$where;
		$count = executeSql($sqlCount);

		$pageCount = ceil($count[0]['num'] / $pageNum);
		$count = $count[0]['num'];

		$sql = "SELECT * from {{user_fields}} where 1=1 ".$where.$order."limit "."$start,". $pageNum;
		$data = executeSql($sql);

	    $info=array(
	    	'info'=>$data,
	    	'page'=>$page,
	    	'pageCount'=>$pageCount,
	    	'count'=>$count,
	    	'uid'=>$_REQUEST['uid']
	    	);

		$this->render('systemrecord',$info);
	}
	//按场记录索引
	public function actionFieldRecord(){

		$page = 1;

        if (Yii::app()->request->getParam('uid')) {
			$uid = Yii::app()->request->getParam('uid');
			$where = " and uid='".Yii::app()->request->getParam('uid')."'";
			if (Yii::app()->request->getParam('stime')) {
				$where .= " and start_time >='".strtotime(Yii::app()->request->getParam('stime'))."'";
				$where .= " and start_time <='".strtotime(Yii::app()->request->getParam('etime'))."'";
			}
		
            $page = $_REQUEST['page'] ? $_REQUEST['page'] :$page;
            $order = 'ORDER BY start_time DESC ';
            $pageNum = 20;
            $start = ($page-1)* $pageNum;

            $sqlCount = "SELECT count(*) as num FROM {{live_logs}} where 1=1 ".$where;
            $count = executeSql($sqlCount);

            $pageCount = ceil($count[0]['num'] / $pageNum);
            $count = $count[0]['num'];

            $sql = "SELECT * from {{live_logs}} where 1=1 ".$where.$order."limit "."$start,". $pageNum;
            $data = executeSql($sql);

            foreach ($data as $k => $v) {
                $v['room_id'];
                $imgurl = IMG_PATH.'201803'."/".date('Ymd',$v['start_time'])."/";
                $url = IMG_URL.'201803'."/".date('Ymd',$v['start_time'])."/";
                $img = $this->_getFile($url);
                $data[$k]['img'] = $imgurl.$this->_checkImg($v['start_time'],$img);
            }

            $uinfo = $this->_getUserInfo($uid);

            $info=array(
                'info'=>$data,
                'page'=>$page,
                'pageCount'=>$pageCount,
                'count'=>$count,
                'username'=>$uinfo['username'],
                'ufname'=>$uinfo['family_name'],
                'uid'=>$_REQUEST['uid']
                );
            $this->render('fieldrecord',$info);
	    
	    }

	}
	private function _getUserInfo($uid){

		$sqlFileds = "select u.username,f.family_name from {{user}} u LEFT JOIN {{family_limits}} fl ON fl.uid = u.uid LEFT JOIN {{family}} f ON f.family_id = fl.family_id WHERE u.uid='".$uid."'";
		
		return yii::app()->db->createCommand($sqlFileds)->queryRow();

	}
	private function _checkImg($time,$data){

		$time = date('YmdHi00',$time);
		
		foreach ($data as $k => $v) {
			
			$str = preg_replace('/\D/s', '', $v);

			if ($str > $time) {
				$img = $v;
				break;
			}
			
		}
		return $img;

	}
	private function _getImgInfo($stime,$etime,$roomid){

        $imgInfo = array();
			
		for ($i=0; $stime<=$etime; $i++) { 
		
			$imgurl = IMG_PATH.'201803'."/".date('Ymd',$stime)."/";
			
			$url = IMG_URL.'201803'."/".date('Ymd',$stime)."/";
			
			$img = $this->_getFile($url);
			
			$imgInfo = array_flip(array_flip(array_merge($imgInfo,$img)));
			
			$stime = $stime+24*3600;
		}
		return $imgInfo;
	}
	//某场直播监控查看
	public function actionFieldLive(){

		$stime = strstr($_REQUEST['stime'], '-') ? strtotime($_REQUEST['stime']) :$_REQUEST['stime'];
		$etime = strstr($_REQUEST['etime'], '-') ? strtotime($_REQUEST['etime']) :$_REQUEST['etime'];

        $page = 1;

        if (Yii::app()->request->getParam('uid')) {
			$uid = Yii::app()->request->getParam('uid');
			$roomid = Yii::app()->request->getParam('roomid');
			$where = " and uid='".Yii::app()->request->getParam('uid')."'";
		}
		$page = $_REQUEST['page'] ? $_REQUEST['page'] :$page;

		
		$imgInfo = $this->_getAllImg($stime,$etime,$this->_getImgInfo($stime,$etime,$roomid));

		
		
		$pageNum = 40;
		$start = ($page-1)* $pageNum;

		$count = count($imgInfo);
		$pageCount = ceil($count / $pageNum);

		$uinfo = $this->_getUserInfo($uid);
		$imgInfo = array_slice($imgInfo, ($page-1)*$pageNum,$pageNum);

        $info=array(
	    	'info'=>$imgInfo,
            'roomid'=>$roomid,
	    	'imgurl'=>$imgurl,
	    	'stime'=>$stime,
	    	'etime'=>$etime,
	    	'page'=>$page,
	    	'pageCount'=>$pageCount,
	    	'count'=>$count,
	    	'username'=>$uinfo['username'],
	    	'ufname'=>$uinfo['family_name'],
	    	'uid'=>$_REQUEST['uid']
	    	);

        $this->render('fieldlive',$info);
	}
    //违规管理
    public function actionViolation(){


        if(Yii::app()->request->isAjaxRequest){

            $violation = new Violation();

            $violation->uid = Yii::app()->request->getParam('uid');
            $violation->roomid = Yii::app()->request->getParam('roomid');
            $violation->images = Yii::app()->request->getParam('images');
            $violation->type = Yii::app()->request->getParam('type');
            $violation->createtime = time();
            
            if($violation->save()){

                echo CJSON::encode(array(1));
            }else{
                echo CJSON::encode(array(0));
            }
        }
    }
    //监控违规
    public function actionMonitoeViol(){

        $page = 1;
        
        $uid = Yii::app()->request->getParam('uid');

        if (Yii::app()->request->getParam('uid')) {

       		$where .= " and v.uid='".Yii::app()->request->getParam('uid')."'";
        }
        if (Yii::app()->request->getParam('type')) {

       		$where .= " and v.type='".Yii::app()->request->getParam('type')."'";
        }
        if (Yii::app()->request->getParam('stime')) {

            $where .= " and v.createtime >='".strtotime(Yii::app()->request->getParam('stime'))."'";
            $where .= " and v.createtime <='".strtotime(Yii::app()->request->getParam('etime'))."'";
        }
        

        $page = $_REQUEST['page'] ? $_REQUEST['page'] :$page;
        $order = 'ORDER BY createtime DESC ';

        $pageNum = 20;
        $start = ($page-1)* $pageNum;
        $sqlCount = "SELECT count(*) as num FROM {{violation}} where 1=1 ".$where;

        $count = executeSql($sqlCount);

        $pageCount = ceil($count[0]['num'] / $pageNum);
        $count = $count[0]['num'];
   		$sql = "SELECT v.*,u.username,f.family_name from {{violation}} v LEFT JOIN {{user}} u ON u.uid=v.uid LEFT JOIN {{family_limits}} fl ON fl.uid=v.uid LEFT JOIN {{family}} f ON f.family_id=fl.family_id ";

        $data = executeSql($sql);

        $info=array(
            'info'=>$data,
            'page'=>$page,
            'pageCount'=>$pageCount,
            'count'=>$count,
            'uid'=>$_REQUEST['uid']
        );

        $this->render('monitoeviol',$info);
    }
	private function _getAllImg($stime,$etime,$data){

		$stime = date('YmdHi00',$stime);
		$etime = date('YmdHi20',$etime);
		
		foreach ($data as $k => $v) {
			
			$str = preg_replace('/\D/s', '', $v);

			if ($str > $stime && $str <=$etime) {

				$result[$str] = $v;
			}
			
		}
		
		return $result;
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
                'actions'=>array('index','monitoeviol','Violation','CheckRoomLive','change','minindex','FieldLive','FieldRecord','GetIMages','systemrecord','aclist'),
                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }



}