<?php
/*
*后台用户模型
*/
class User extends CActiveRecord{


    public $password;
    public $username;

	const PAGE_NUMBER = 13;
	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){
		return parent::model($className);
	}
	/*
	*返回表名
	*/
	public function tableName(){
		return "{{user}}";
	}
   
    public function attributeLabels() {
        return array(
            'username' =>'用户帐号',
            'password' => '登录密码',
            'password2' => '再次输入密码',
            'virtual'=>'加到虚拟人库'
        );
    }
     /**
     * 获取用户靓号
     * @param int $uid
     * @return 用户靓号
     */
    public function getUserNicegid($uid){

      $criteria = new CDbCriteria;
      $criteria->select = 'gid';
      $criteria->condition = "uid = '".$uid."'";
      $result = $this->find($criteria);
      
      return  $result['gid'] ?  $result['gid'] : $uid;
    }
    /**
     * 获取用户昵称  如果昵称为空，则取用户名作为昵称
     *
     * @param int $uid
     * @return 昵称
     */
    public function getUserNick($uid){

      if ($uid){
          
          $nickname = UserFields::model()->getNickName($uid); 

          if ($nickname){

            return $nickname;

          }else{

            return $this->getUserName($uid);
          }
      }else {

          return '';
      }

    }
     /**
     * 获取用户账号
     */
    public function getUserName ($uid){

      $criteria = new CDbCriteria;
      $criteria->select = 'username';
      $criteria->condition='uid=:uid';
      $criteria->params=array(':uid'=>$uid);
      
      $result = $this->find($criteria);
      
      return  !empty($result) ? $result['username']:0;
    }
    
    /*
     * 通过昵称获取UID
  */
    public function getUidByNickname($username){

        $uid = UserFields::model()->getUid($username); 
        if (!$uid) {

          $uid = $this->getUidByUsername($username);
      }
      return $uid;
    }
     /**
     * 通过用户账号获取到UID
     *
     * @param string $username
     * @return uid
     */
    public function getUidByUsername($username) {

          $criteria = new CDbCriteria;
          $criteria->select = 'uid';
          $criteria->condition='username=:nickname';
          $criteria->params=array(':nickname'=>$username);
        
          $result = $this->find($criteria);

          return !empty($result) ? $result['uid']: 0;

    }

    public function getUidByGid($gid){

        if(!is_numeric($gid) || !$gid){

          return '';
        }
        if ($gid > GID_MAX_LENGHT && $gid <= UID_MAX_LENGHT){// 如果靓号大于 9999999说明是UID 直接返回
            
            if($this->_checkGid('uid',$gid)) {

              return $gid;

            }else{ 

              return '';
            }
        }else{
            
          return $this->_checkGid('gid',$gid);
        }

    }
    private function _checkGid($uid,$username){

        $userModel = User::model();

        $user = $userModel::model()->find(array(
            'select' =>array('uid'),
            'condition' => ''.$uid.'='."'".$username."'",
        ));
        return  $user['uid'] ? $user['uid']  : '';

    }
    /**
     * 检查UID是否已存在
     *
     * @param string $uid
     * @return 如果存在返回UID，不存在返回0
     */
    public function checkUid($uid){

        $criteria = new CDbCriteria;
        $criteria->select = 'uid';
        $criteria->condition='uid=:uid';
        $criteria->params=array(':uid'=>$uid);
        
        $result = $this->find($criteria);

        return !empty($result) ? $result['uid']: 0;
    }

    /* 
    *获取相应字段的名称名称
    * 根据UID
     */
    public function getFieldsName($fields,$uid){

        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition='uid=:uid';
        $criteria->params=array(':uid'=>$uid);
        
        $result = $this->find($criteria);

        return !empty($result) ? $result[$fields]: 0;

    }
    public function getSuid($username){

       $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition='username=:username';
        $criteria->params=array(':username'=>$username);
        
        $result = $this->find($criteria);

        return !empty($result) ? $result['uid']: 0;
    }
    public function getUserInfo($username,$password){
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition='username=:username and password=:password';
        $criteria->params=array(':username'=>$username,':password'=>md5($password));
        $userInfo = $this->find($criteria);
        return !empty($userInfo) ? $userInfo :'';
    }
        /**
     * 检查用户名是否已存在
     *
     * @param string $username
     * @return 如果存在返回用户名，不存在返回false
     */
    public function checkUsername ($username){

        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition='username=:username';
        $criteria->params=array(':username'=>$username);
        
        $result = $this->find($criteria);

        return !empty($result) ? $result['username']: 0;
    }
     

}
?>