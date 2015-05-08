<?php
/*
* 家族成员模型
*/
class FamilyLimits extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName($uid){
		return "{{family_limits}}";
	}
	public function getUid($uid,$exclude=''){
		$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition='uid=:uid AND family_id <>:family_id';
		$criteria->params=array(':uid'=>$uid,':family_id'=>$exclude);
	      
	    $result = $this->find($criteria);

	    return !empty($result) ? true :false;
	}
	
    
}
?>