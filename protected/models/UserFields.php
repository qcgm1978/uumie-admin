<?php
/*
*用户字段模型
*/
class UserFields extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{user_fields}}";
	}

	 /**
     *获取用户昵称
     */
    public function getNickName($uid){

      $criteria = new CDbCriteria;
      $criteria->select = 'nickname';
      $criteria->condition='uid=:uid';
	    $criteria->params=array(':uid'=>$uid);
      
      $result = $this->find($criteria);

      return  !empty($result) ? $result['nickname']: 0;
    }
    
     /**
     *获取用户UID
     */
    public function getUid($username){

      $criteria = new CDbCriteria;
      $criteria->select = 'uid';
      $criteria->condition='nickname=:nickname';
	    $criteria->params=array(':nickname'=>$username);
      
      $result = $this->find($criteria);

      return  !empty($result) ? $result['uid']: 0;
    }
}
?>