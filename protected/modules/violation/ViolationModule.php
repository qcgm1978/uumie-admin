<?php

class ViolationModule extends CWebModule
{
	public function init()
	{

		//自定义默认控制器
		$this->defaultController = "index";
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'violation.models.*',
			'violation.components.*',
		));
		Yii::app()->setComponents(array(
			'user'	=> array('stateKeyPrefix'	=> 'admin'),
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
