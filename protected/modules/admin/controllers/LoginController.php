<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
**后台登录控制器
*/
class LoginController extends Controller{
	/*
	*后台登录
	*/
	public function actionIndex(){
		$loginForm = new LoginForm();
		// $userInfo = User::model()->find('username=:name',array(':name'=>'admin'));
		// p($userInfo);exit();
		if(isset($_POST['LoginForm'])){
			$loginForm->attributes = $_POST['LoginForm'];
			if($loginForm->validate() && $loginForm->login()){
				Yii::app()->session['logintime'] = time();
				$userInfo = User::model()->find('username=:name',array(':name'=>$_SESSION['username']));
				$_SESSION['uid'] = $userInfo['uid'];

				$_SESSION['action_list'] = Admin::model()->isAdmin($_SESSION['uid']);
				
				User::model()->updateByPk($userInfo['uid'],array('last_login'=>time(),'last_login_ip'=>userRealIp()));			
				$this->redirect(array('default/index'));
			}
		}
		$this->renderPartial('index',array('loginForm'=>$loginForm));
	}
	
	/*
	*注销
	*/	
	public function actionOut(){
		Yii::app()->user->logout();
		$this->redirect(array('index'));
	}

	//验证码
	public function actions(){
		return array(
			'captcha'	=> array(
					'class'	=> 'system.web.widgets.captcha.CCaptchaAction',
					'height' => 25,
					'width'	 => 80,
					'minLength'=> 4,
					'maxLength'=> 4

				),

			);
	}

}
?>