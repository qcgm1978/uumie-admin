<?php
/*
*家族模型
*/
class Family extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{family}}";
	}
	public function getFamilyId($familyname){

		$criteria = new CDbCriteria;
      	$criteria->select = 'family_id';
     	$criteria->condition='family_name=:family_name';
	 	$criteria->params=array(':family_name'=>$familyname);
	 	$familyInfo = $this->find($criteria);
	 	return !empty($familyInfo) ? $familyInfo['family_id'] :'';
	}
	
	//获取座驾种类
	public function getCarType(){

		$sql = "SELECT id, name FROM {{car}}";
			
		$carInfo = yii::app()->db->createCommand($sql)->queryAll();

	 	return $carInfo;
	}
	//获取车id
	public function getCarId($carname){

		$criteria = new CDbCriteria;
      	$criteria->select = 'id';
     	$criteria->condition='name=:name';
	 	$criteria->params=array(':name'=>$carname);
	 	$carInfo = $this->find($criteria);
	 	return !empty($carInfo) ? $carInfo['id'] :'';
	}
	//获取车id
	public function getFname($carname){

		$criteria = new CDbCriteria;
      	$criteria->select = 'family_name';
     	$criteria->condition='family_id=:family_id';
	 	$criteria->params=array(':family_id'=>$carname);
	 	$carInfo = $this->find($criteria);
	 	return !empty($carInfo) ? $carInfo['family_name'] :'';
	}
	 /**
     * 获取家族名称 
     *
     * @param int $uid
     * @return 昵称
     */
    public function getFamilyName($fid){
    	$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition='family_id=:family_id AND del_flag>=:del_flag';
		$criteria->params=array(':family_id'=>$fid,':del_flag'=>0);
      
      $result = $this->find($criteria);

      return  !empty($result) ? $result:'';
    	
    }
    
	
    
}
?>