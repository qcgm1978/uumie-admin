<?php
/*
*用户消费等级模型
*/
class UserTitle extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{user_title}}";
	}

	 /**
     * 获取印章ID
     *
     * @param int $uid
     * @return 返回印章ID
     */
    public function userBadgeId($uid){

	   	$point = UserAccount::model()->find(array(
			  'select' =>array('expense_point'),
			  'condition' => 'uid='."'".$uid."'",
			));	
		if ($point['expense_point'] < 1000 ) {
			
			$title = 0;
		}else{
			  $criteria = new CDbCriteria;
		      $criteria->select = 'title_id';
		      $criteria->condition='min_points<=:point';
			  $criteria->params=array(':point'=>$point['expense_point']);
			  $criteria->order = 'title_id DESC';
			  $result = $this->find($criteria);
			  $title = empty($result) ? 0 : $result['title_id'] ;
		}
								
      return  $title;
    }
    
}
?>