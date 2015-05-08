<?php
/*
*汽车模型
*/
class Car extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{car}}";
	}
	public function getCarName($carid){
		$criteria = new CDbCriteria;
      	$criteria->select = 'name';
     	$criteria->condition='id=:carid';
	 	$criteria->params=array(':carid'=>$carid);
	 	$carInfo = $this->find($criteria);
	 	return !empty($carInfo) ? $carInfo['name'] :'';
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
	/**
	 * 取得座驾信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function getCarInfo($id){
		
		$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition='id=:id';
		$criteria->params=array(':id'=>$id);
	      
	    $result = $this->find($criteria);
	    
	    return !empty($result) ? $result :'';

	}

	
    
}
?>