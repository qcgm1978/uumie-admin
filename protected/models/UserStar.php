<?php
/*
*用户明星等级 模型
*/
class UserStar extends CActiveRecord{

  	/*
  	*返回模型
  	*/
  	public static function model($className = __CLASS__){

  		return parent::model($className);
  		
  	}
  	public function tableName(){
  		return "{{user_star}}";
  	}

	 
    /**
     * 获取用户明星等级
     *
     * @param int $uid
     * @return int
     */
    public function getUserStar($uid){   
       
    	$point = UserAccount::model()->find(array(
			  'select' =>array('income_point'),
			  'condition' => 'uid='."'".$uid."'",
			));
		
         $criteria = new CDbCriteria;
         $criteria->select = 'min_points';
         $criteria->order = 'min_points ASC';
         $criteria->limit = 1;
         $stars = $this->find($criteria);

        if($point['income_point'] < $stars['min_points']){

         	$star = 1;
        }else{
              $criteria = new CDbCriteria;
              $criteria->select = 'star_id';
              $criteria->condition='min_points<=:point';
              $criteria->params=array(':point'=>$point['income_point']);
              $criteria->order = 'star_id DESC';
              $result = $this->find($criteria);
              
              $star = empty($result) ? 0 : $result['star_id'] ;

        }

        return $star;
    }
    
}
?>