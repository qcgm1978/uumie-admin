<?php
/*
* 服务器模型
*/
class RoomServer extends CActiveRecord{

	/*
	*返回模型
	*/

	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{room_server}}";
	}
	//查看服务器是否存在
	public function getSid($sid,$exclude=''){

	    $criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition='number=:number AND id <>:id';
		$criteria->params=array(':number'=>$sid,':id'=>$exclude);
	      
	    $result = $this->find($criteria);
	    
	    return !empty($result) ? true :false;
  	}

  	public function getServerInfo($id){

  		$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition='id=:id';
		$criteria->params=array(':id'=>$id);
	      
	    $result = $this->find($criteria);
	    
	    return !empty($result) ? $result :'';
  	}
  	public function getServerType($id){

  		$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition='id=:id';
		$criteria->params=array(':id'=>$id);
	      
	    $result = $this->find($criteria);
	    
	    return !empty($result) ? $result['type'] :'';
  	}
  	/**
	 * 取得服务器组列表
	 * @access  public
	 * @param   int     $selected   当前选中服务器ID
	 * @param   boolean $re_type    返回的类型: 值为真时返回返回数组,否则返回下拉列表
	 */
	public function serverList($selected = 0, $re_type = true) {
		$sql = "SELECT *,number as rooms FROM {{room_server}} ORDER BY id ASC"; 			

		$result = yii::app()->db->createCommand($sql)->queryAll();
		
	    foreach ($result as $k => $v) {
			$result[$k]['rooms'] = Room::model()->getRoomsCount($v['id']);
	    }
		
		if($re_type == true){
			return $result;
		}else{
			$select = '';
			foreach($result as $row){
				$select .= '<option value="' . $row['id'] . '" ';
				$select .= ($selected == $row['id']) ? "selected='ture'" : '';
				$select .= '>';
				$select .= htmlspecialchars($row['name'] . ' (已' . $row['rooms'] . '房)', ENT_QUOTES) . '</option>';
			}
			return $select;
		}
	}
	
    
}
?>