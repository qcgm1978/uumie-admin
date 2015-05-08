<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class userForm extends CFormModel
{
	public $username;
	public $password;
	public $password2;
	

	public function rules(){
        return array(
            array('username', 'required', 'message'=>'用户名不能为空'),
            array('username', 'unique', 'message'=>'用户名已经被占用'),
            array('password', 'required', 'message'=>'密码不能为空'),
            array('password2', 'compare', 'compareAttribute' => 'password', 'message'=>'两次密码不一致')
            
            );
    }
    public function attributeLabels() {
        return array(
            'username' => '用 户 名：',
            'password' => '密    码：',
            'password2' => '重复密码：'
        );
    }
	
}
