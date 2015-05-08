<?php
/*
*VIP 模型
*/
class UserBadge extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{user_badge}}";
	}

	 /**
     * 获取印章ID
     *
     * @param int $uid
     * @return 返回印章ID
     */
    public function userBadgeId($uid){

      $criteria = new CDbCriteria;
      $criteria->select = 'badge_id';
      $criteria->condition='uid=:uid AND expire_time>=:expiretime';
	  $criteria->params=array(':uid'=>$uid,':expiretime'=>time());
      
      $result = $this->find($criteria);
      return  !empty($result) ? intval($result['badge_id']):0;
    }
    
}
?>