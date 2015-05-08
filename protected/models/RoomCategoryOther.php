<?php
/*
* 房间扩展模型
*/
class RoomCategoryOther extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{room_category_other}}";
	}
	/**
	 * 保存房间的扩展分类
	 * @param   int     $room_id   房间编号
	 * @param   array   $cat_list  分类编号数组
	 * @return  void
	 */
	public function handleOtherCat($roomid, $catlist){

		/* 查询现有的扩展分类 */
	    $sql = "SELECT cat_id FROM {{room_category_other}} WHERE room_id = '$roomid'";
		$catInfo = yii::app()->db->createCommand($sql)->queryAll();
		foreach ($catInfo as $k => $v) {
			$existlist[] = $v['cat_id'];
		}
		$deletelist = array_diff($existlist, $catlist);
		if (!empty($deletelist)) {
			$roomids = "'".$roomid."'";
			$deletelist = implode(",", $deletelist);
			$deletelist = "(".$deletelist.")";
			RoomCategoryOther::model()->deleteAll('cat_id in '.$deletelist.'AND room_id='.$roomids);
		}

		$existlist = !empty($existlist) ? $existlist :  array(0);
		$addlist = array_diff($catlist, $existlist, array(0));
		
		foreach ($addlist as $catid) {
			$addrco = new RoomCategoryOther();
			$addrco->room_id = $roomid;
			$addrco->cat_id = $catid;
			$addrco->save();
		}
		return true;

	}
	
    
}
?>