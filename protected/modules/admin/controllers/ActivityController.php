<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
**活动管理控制器
*/
class ActivityController extends Controller{

	/*
	*审核回复列表
	*/
	public function actionIndex(){

		if (Yii::app()->request->isAjaxRequest) {
			$where = " 1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			
			if (Yii::app()->request->getParam('nickname')) {
				$uid = User::Model()->getUidByNickname(trim(Yii::app()->request->getParam('nickname')));
				if ($uid) {
					$where .= " AND uid = '" . mysqlLikeQuote($uid) . "'";
				}
			}
			
			if (Yii::app()->request->getParam('type')) {
				$where .= " and type = '".Yii::app()->request->getParam('type')."'";
			}
			if (Yii::app()->request->getParam('audit')) {
				$where .= " and audit = '".trim(Yii::app()->request->getParam('audit'))."'";
			}
			
			if (Yii::app()->request->getParam('starttime')) {
				$where .= " and add_time >= '".strtotime(Yii::app()->request->getParam('starttime'))."'";
			}
			if (Yii::app()->request->getParam('endtime')) {
				$where .= " and add_time <= '".strtotime(Yii::app()->request->getParam('endtime'))."'";
			}				
			
			$order = 'ORDER BY id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{user_answer}} where ".$where.$order."limit "."$start,". PAGE_NUMBER; 			

			$numbers = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) AS num FROM {{user_answer}}  where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			$type = $this->_audit();
			foreach ($numbers as $k => $v) {
				// var_dump($v);exit();
				$numbers[$k]['nickname'] = User::model()->getUserNick($v['uid']);			
				$numbers[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);			
				$numbers[$k]['operat'] = '<input type="checkbox" name="demo" value="'.$v['id'].'" />';
				$numbers[$k]['id'] = '<span style="cursor:pointer;color:#0088cc" onClick="recommed('.$v['id'].',1,1'.')">审核通过</span> | <span style="cursor:pointer;color:#0088cc" onClick="recommed('.$v['id'].',2,1'.')">审核不通过</span>';

				$numbers[$k]['audit'] = $type[$v['audit']];
			}

			if($page > $pageCount) $page = $pageCount;

			$numbers = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$numbers);
			
			echo CJSON::encode($numbers);	
		}else{

			$this->render('index');
		}
		
		
	}
	//更新推荐
	public function actionRecommend(){
		if (Yii::app()->request->isAjaxRequest) {

			$id = Yii::app()->request->getParam('id');
			$status = Yii::app()->request->getParam('status');
			$type = Yii::app()->request->getParam('type');
			$id = "(".$id.")";
			switch ($type) {
				
				case '1':
					$data = array('audit'=>$status);
					break;
			}
			if (UserAnswer::model()->updateAll($data,'id in'.$id)) {
					AdminLog::model()->adminLogs("审核:".Yii::app()->request->getParam('id'));
					echo CJSON::encode(array(1));

			}else{

				echo CJSON::encode(array(0));
			}
			
		}

	}
	public function actionAcList(){

		if (Yii::app()->request->isAjaxRequest) {
			if (checkAuthzJson("answer_list")) {
				$sql = "SELECT MAX(times) as mtime FROM  {{user_answer}}";
				$giftMaxTimes = yii::app()->db->createCommand($sql)->queryRow();
				$giftMaxTimes = $giftMaxTimes['mtime'];
				$sqlup = "UPDATE {{user_answer}} SET times=".($giftMaxTimes+1)." WHERE id in(select t.id from(SELECT id FROM {{user_answer}} WHERE audit=1 AND times=0) t )";

				if (Yii::app()->db->createCommand($sqlup)->execute()) {
					$sqlsel = "SELECT uid,times FROM {{user_answer}} WHERE audit=1 and times !=0 ORDER BY id DESC";
					$result = executeSql($sqlsel);;
					foreach ($result as $k => $v) {
						$result[$k]['nickname'] = User::model()->getUserNick($v['uid']);
					}
					Yii::app()->cache->set('hjmd_list', $result);
					AdminLog::model()->adminLogs("发布获奖名单成功");
					echo CJSON::encode(array(1));

				}
				
			}else{
				echo CJSON::encode(array(0));
			}

		}

	}
	private function _audit(){
		return array('0'=>'未审核','1'=>'审核通过','2'=>'审核不通过');
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
                'actions'=>array('index','recommend','aclist'),
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