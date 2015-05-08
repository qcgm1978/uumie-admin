<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$userModel = User::model()->find('username=:name',array(':name'=>$this->username));
        //如果用户名不存在
        if($userModel === null){

            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (trim($userModel->password) !== md5($this->password)){
            //密码判断
            $this->errorCode=self::ERROR_PASSWORD_INVALID;

        } else {
            $this->errorCode=self::ERROR_NONE;
        }
        return $this->errorCode;
	}
}