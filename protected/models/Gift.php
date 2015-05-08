<?php
/*
* 礼物模型
*/
class Gift extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	
	public function tableName(){
		return "{{gift}}";
	}

	/* 判断礼物名称是否已经存在 */
	public function giftNameExists($name, $exclude = '',$giftid =''){

		$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition='gift_name=:gift_name AND gift_name <>:expiretime AND gift_id <>:gift_id';
		$criteria->params=array(':gift_name'=>$name,':expiretime'=>$exclude,':gift_id'=>$giftid);
	      
	    $result = $this->find($criteria);
	    
	    return !empty($result) ? true :false;

	}
	/**
	 * 取得礼物信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function getGiftInfo($id){
		
		$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition='gift_id=:gift_id';
		$criteria->params=array(':gift_id'=>$id);
	      
	    $result = $this->find($criteria);
	    
	    return !empty($result) ? $result :'';

	}

    
}
?>