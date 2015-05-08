<?php
/*
*代理模型
*/
class Agency extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{agency}}";
	}
	// 代理充值折扣
	public function agencyDis($uid){

		$criteria = new CDbCriteria;
	    $criteria->select = 'discount';
	    $criteria->condition='uid=:uid';
		$criteria->params=array(':uid'=>$uid);
	      
	    $result = $this->find($criteria);
	    
	    return !empty($result) ? $result['discount'] :'';
	}
	/**
	  * 代理列表 
	  * @access  public
	  * @param   int     $selected   当前选中代理
	  * @param   boolean $re_type    返回的类型: 值为真时返回返回数组,否则返回下拉列表
	  */
	function agencyList($selected = 0, $re_type = true){
		$sql = "SELECT uid FROM {{agency}} WHERE expire_time > '".time()."' AND is_lock = 0 ORDER BY rank DESC";
		$result = yii::app()->db->createCommand($sql)->queryAll();
		foreach ($result as $k => $v) {
			$result[$i]['nick'] = User::model()->getUserNick($v['uid']);
			$result[$i]['gid']  = $GLOBALS['user']->getUserNicegid($v['uid']);

		}
		for($i = 0; $i < count($res); $i ++){
			$res[$i]['nick'] = $GLOBALS['user']->get_user_nick($res[$i]['uid']);
			$res[$i]['gid']  = $GLOBALS['user']->get_user_nicegid($res[$i]['uid']);
		}	
		if($re_type == true){
			return $res;
		}else{
			$select = '';
			foreach($res as $row){
				$select .= '<option value="' . $row['uid'] . '" ';
				$select .= ($selected == $row['uid']) ? "selected='ture'" : '';
				$select .= '>';
				$select .= htmlspecialchars($row['nick'] . ' (' . $row['gid'] . ')', ENT_QUOTES) . '</option>';
			}
			return $select;
		}
	}
    
}
?>