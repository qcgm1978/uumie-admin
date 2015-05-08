<?php
/*
*主播模型
*/
class Anchor extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	
	public function tableName(){
		return "{{anchor}}";
	}

	/* 是否已经是主播 */
	public function isAnchor($uid){

		$criteria = new CDbCriteria;
        $criteria->select = 'uid';
        $criteria->condition='uid=:uid';
        $criteria->params=array(':uid'=>$uid);
        
        $result = $this->find($criteria);

        return !empty($result) ? $result['uid']: 0;
	}
	/* 主播信息 */
	public function allAnchor($uid){

		$criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition='uid=:uid';
        $criteria->params=array(':uid'=>$uid);
        
        $result = $this->find($criteria);
        
        return !empty($result) ? $result: 0;
	}
	
    
}
?>