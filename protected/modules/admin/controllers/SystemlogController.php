<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
**系统优化
*/
class SystemlogController extends Controller{
	
	/*
	* 管理员日志
	*/
	
	public function actionIndex(){
		
		if (Yii::app()->request->isAjaxRequest) {
			$where = "1=1 ";
			$page =  (int)Yii::app()->request->getParam('page');
			
			
			$page = $page ? $page : 1;

			
			if (Yii::app()->request->getParam('gid')) {

				$uid = User::model()->getUidByGid(trim(Yii::app()->request->getParam('gid')));
				$where .= " and uid='".$uid."'";
			}
			
			if (Yii::app()->request->getParam('uid')) {

				$where.= "and uid = '".trim(Yii::app()->request->getParam('uid'))."'";

			}
			$order = 'ORDER BY log_id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{admin_log}}  where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			
			$syetemLog = executeSql($sql);

			$sqlCount = "SELECT count(*) as num FROM {{admin_log}}  where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($syetemLog as $k => $v) {
				// p($v);exit();
				$gid = User::model()->getUserNicegid($v['uid']);
				$nickname = User::model()->getUserNick($v['uid']);
				// p($nickname);
				$syetemLog[$k]['log_time'] = date('Y-m-d H:i:s',$v['log_time']);
				$syetemLog[$k]['operat'] = '<input type="checkbox" name="demo" value="'.$v['log_id'].'" />';
				$syetemLog[$k]['nick_name'] = $gid ? $nickname.'(<a href="'.$this->createUrl("systemlog/index",array('uid'=>$v['uid'])).'">'.$gid.'</a>)' : '系统定时任务自动执行';

			}

			if($page > $pageCount) $page = $pageCount;

			$syetemLog = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$syetemLog);
			
			echo CJSON::encode($syetemLog);	
			
		}else{

			$this->render('index',array('uid'=>$_REQUEST['uid']));	
		}
	}
	public function actionDel(){

		if (Yii::app()->request->isAjaxRequest) {
			$logid = Yii::app()->request->getParam('logid');
			switch ($logid) {
				case '1':
					$time = time()-(3600 * 24 * 7);
					$where = "log_time <= '".$time."'";
					break;
				case '2':
					$time = time()-(3600 * 24 * 30);
					$where = "log_time <= '".$time."'";
					break;
				case '3':
					$time = time()-(3600 * 24 * 90);
					$where = "log_time <= '".$time."'";
					break;
				case '4':
					$time = time()-(3600 * 24 * 180);
					$where = "log_time <= '".$time."'";
					break;
				case '5':
					$time = time()-(3600 * 24 * 365);
					
					$where = "log_time <= '".$time."'";
					break;				
				default:
					$where = 'log_id in '."(".$logid.")";
					break;
			}
			
			if (AdminLog::model()->deleteAll($where)) {

					echo CJSON::encode(array(2));

			}
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
                'actions'=>array('index','del'),
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