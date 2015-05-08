<?php
/*
* Vip模型
*/
class VipVip extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{vip_vip}}";
	}
	/**
	 * 取得vip组列表
	 * @access  public
	 * @param   int     $selected   当前选中爵位ID
	 * @param   boolean $re_type    返回的类型: 值为真时返回返回数组,否则返回下拉列表
	 */
    public function vipsList($selected = 0, $retype = true){

	    $criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->order = 'id';
	    $result = $this->findAll($criteria);
	    
	   if($re_type == true){

			return $result;
		}else{

			$select = array();
			foreach($result as $key => $val){

				$select[$key]['id']	= $val['id'];
				$select[$key]['name']	= htmlspecialchars($val['name'].($val['expire_time']/3600/24)."天" , ENT_QUOTES);				 
			}
			return $select;
		}
    }
    // 获取爵位道具信息
    public function getTitleInfo($vip_id){

    	$criteria = new CDbCriteria;
	    $criteria->select = '*';
	    $criteria->condition = "id = '".$vip_id."'";
	    $result = $this->find($criteria);
      
      return  $result['expire_time'] ?  $result['expire_time'] :'';
    }
    
}
?>