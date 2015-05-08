<?php
/*
* VIP模型
*/
class Vip extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{vip}}";
	}

	/* 根据VIPID获取VIP名称 */
	public function getVipName($vipid) {

	  $criteria = new CDbCriteria;
      $criteria->select = 'name';
      $criteria->condition='id=:id';
	  $criteria->params=array(':id'=>$vipid);
      
      $result = $this->find($criteria);
      return  !empty($result) ? $result['name']:'';

	}
	public function getVipId($sumconsume,$money){
		$sql = "SELECT id FROM {{vip}} WHERE first_recharge <= ".($sumconsume+$money)." ORDER BY first_recharge DESC LIMIT 1";
		$result = yii::app()->db->createCommand($sql)->queryRow();
		return !empty($result['id']) ? $result['id'] : 0;
	} 
	/**
	 * 取得爵位组列表
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
				$select[$key]['name']	= htmlspecialchars($val['name'] , ENT_QUOTES);				 
			}
			return $select;
		}
    }
}
?>