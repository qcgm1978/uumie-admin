<?php
/*
* 道具模型
*/
class Magic extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
	
		return "{{magic}}";
	}

	/* 获取道具名称 */
	public function getMagicName($magicid,$fields){

		$criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition='magic_id=:magic_id';
        $criteria->params=array(':magic_id'=>$magicid);
        
        $result = $this->find($criteria);

        return !empty($result) ? $result[$fields]: 0;

	}
	// 获取爵位道具信息
	public function getMagicInfo($vip_id){

		$criteria = new CDbCriteria;
      	$criteria->select = 'magic_name, vip_id, time_limit, add_coin';
     	$criteria->condition='vip_id=:vip_id';
	 	$criteria->params=array(':vip_id'=>$vip_id);
	 	$vipInfo = $this->find($criteria);
	 	return $vipInfo;
	}
	
    
}
?>