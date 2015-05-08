<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
class DefaultController extends Controller{

	// public $layout='/layouts/column1';

	public function actionIndex(){

		$data = array(
			'sscpay'=>PayLogs::model()->getSscPay(),
			'invpay'=>PayLogs::model()->getInvPay()
			);
		$this->render('index',$data);
	}
	public function actionCopy(){
		$this->renderPartial('copy');
	}
	public function actionTest(){
		$cri = new CDbCriteria();
		$userModel = User::model();
		$total = $userModel->count($cri);
		$pager = new CPagination($total);
		$pager->pageSize = 10;
		$pager->applyLimit($cri);
		$userInfo = $userModel->findAll($cri);
		$data = array(
			'userInfo' =>$userInfo,
			'pages'    =>$pager
			);
		$this->renderPartial('test',$data);
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
                'actions'=>array('index'),
                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }
}