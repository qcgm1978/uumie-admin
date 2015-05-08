<?php
/*
*房间分类模型
*/
class RoomCategory extends CActiveRecord{

	/*
	*返回模型
	*/
	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{room_category}}";
	}
	
	/**
	 * 获得指定房间分类下的子分类的数组
	 * @access  public
	 * @param   int     $cat_id     分类的ID
	 * @param   int     $selected   当前选中分类的ID
	 * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
	 * @param   int     $level      限定返回的级数。为0时返回所有级数
	 * @param   int     $is_show_all 如果为true显示所有分类，如果为false隐藏不可见分类。
	 * @param   int     $is_show_link 如果为true显示所有分类，如果为false隐藏带连接的分类。
	 * @return  mix
	 */
	public function catList($cat_id = 0, $selected = 0, $re_type = false, $level = 0, $is_show_all = true, $is_show_link = true) {
		
		static $result = NULL;

		if ($result === NULL) {
			$mem=new Memcache;  
		    $mem->connect("localhost",11211);    //pconnect长链接  
		    // $mem->add("mystr","this is a memcache test!",MEMCACHE_COMPRESSED,3600);  
		    // $str=$mem->get("mystr");  
		    // echo "string: ".$str."<br />";  
		    // $mem->add("myarr",array("aaa","bbb","ccc","ddd"));  
		    // print_r($mem->get("myarr"));  
		    // exit();
			$value = Yii::app()->cache->get('catpidreleate');

			if ($value === false) {
				$sql = "select t.cat_id,t.cat_name,t.parent_id,t.is_show,t.sort_order,t.link_url,COUNT(s.cat_id) AS has_children,t.link_url as child,t.link_url as opera from {{room_category}} t LEFT JOIN {{room_category}} s ON s.parent_id = t.cat_id group by t.cat_id order by t.parent_id,t.sort_order DESC";
				// var_dump($sql);exit();	
				// $criteria = new CDbCriteria;
			 //    $criteria->select = '';
			 //    $criteria->join = 'LEFT JOIN {{room_categoryg}} s ON s.parent_id = t.cat_id';
			 //    $criteria->group  = 't.cat_id';
			 //    $criteria->order = 't.parent_id,t.sort_order DESC';  
			    $result = yii::app()->db->createCommand($sql)->queryAll();
			    Yii::app()->cache->set('catpidreleate', $result, 3600);
			}else{
				$result = $value;
			}
		}
		
		if (empty($result)==true) {

			return $re_type ? '' : array();
		}

		$options = $this->_catOptions($cat_id,$result);

		$children_level = 99999; //大于这个分类的将被删除

		/* 是否隐藏 */
		if($is_show_all == false){
			foreach($options as $key=>$val){
				if($val['level'] > $children_level){
					unset($options[$key]);
				}else{
					if($val['is_show'] == 0){
						unset($options[$key]);
						if($children_level > $val['level']){
							$children_level = $val['level']; //标记一下，这样子分类也能删除
						}
					}else{
						$children_level = 99999; //恢复初始值
					}
				}
			}
		}

		/* 是否显示带URL连接的分类 */
		if($is_show_link == false){
			foreach($options as $key=>$val){
				if($val['level'] > $children_level){
					unset($options[$key]);
				}else{
					if($val['link_url']){
						unset($options[$key]);
						if($children_level > $val['level']){
							$children_level = $val['level']; //标记一下，这样子分类也能删除
						}
					}else{
						$children_level = 99999; //恢复初始值
					}
				}
			}
		}

		/* 截取到指定的缩减级别 */
		if($level > 0){
			if($cat_id == 0){
				$end_level = $level;
			}else{
				$first_item = reset($options); // 获取第一个元素
				$end_level = $first_item['level'] + $level;
			}
			
			/* 保留level小于end_level的部分 */
			foreach($options as $key=>$val){
				if($val['level'] >= $end_level){
					unset($options[$key]);
				}
			}
		}

		if($re_type == true){

			$select = '';
			
			foreach($options as $var){
				$select .= '<option value="' . $var['cat_id'] . '" ';
				$select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
				$select .= '>';
				if($var['level'] > 0){
					$select .= str_repeat('&nbsp;', $var['level'] * 4);
				}
				$select .= htmlspecialchars($var['cat_name'], ENT_QUOTES) . '</option>';
			}
			
			return $select;
		}else{

			return $options;
		}
	}

	    /**
	 * 过滤和排序所有房间分类，返回一个带有缩进级别的数组
	 *
	 * @access  private
	 * @param   int     $cat_id     上级分类ID
	 * @param   array   $arr        含有所有分类的数组
	 * @param   int     $level      级别
	 * @return  void
	 */
	private function _catOptions($spec_cat_id, $arr) {
		static $cat_options = array();
		
		if(isset($cat_options[$spec_cat_id])){
			return $cat_options[$spec_cat_id];
		}
		
		if(! isset($cat_options[0])){
			$level = $last_cat_id = 0;
			$options = $cat_id_array = $level_array = array();
			$data = Yii::app()->cache->get('cat_option_static');
			if($data === false){
				while(! empty($arr)){
					foreach($arr as $key=>$value){
						$cat_id = $value['cat_id'];
						if($level == 0 && $last_cat_id == 0){
							if($value['parent_id'] > 0){
								break;
							}
							
							$options[$cat_id] = $value;
							$options[$cat_id]['level'] = $level;
							$options[$cat_id]['id'] = $cat_id;
							unset($arr[$key]);
							
							if($value['has_children'] == 0){
								continue;
							}
							$last_cat_id = $cat_id;
							$cat_id_array = array($cat_id);
							$level_array[$last_cat_id] = ++ $level;
							continue;
						}
						
						if($value['parent_id'] == $last_cat_id){
							$options[$cat_id] = $value;
							$options[$cat_id]['level'] = $level;
							$options[$cat_id]['id'] = $cat_id;
							unset($arr[$key]);
							
							if($value['has_children'] > 0){
								if(end($cat_id_array) != $last_cat_id){
									$cat_id_array[] = $last_cat_id;
								}
								$last_cat_id = $cat_id;
								$cat_id_array[] = $cat_id;
								$level_array[$last_cat_id] = ++ $level;
							}
						}elseif($value['parent_id'] > $last_cat_id){
							break;
						}
					}
					
					$count = count($cat_id_array);
					if($count > 1){
						$last_cat_id = array_pop($cat_id_array);
					}elseif($count == 1){
						if($last_cat_id != end($cat_id_array)){
							$last_cat_id = end($cat_id_array);
						}else{
							$level = 0;
							$last_cat_id = 0;
							$cat_id_array = array();
							continue;
						}
					}
					
					if($last_cat_id && isset($level_array[$last_cat_id])){
						$level = $level_array[$last_cat_id];
					}else{
						$level = 0;
					}
				}
				Yii::app()->cache->set('cat_option_static',$options,3600);

			}else{
				$options = $data;
			}
			$cat_options[0] = $options;
		}else{
			$options = $cat_options[0];
		}
		
		if(! $spec_cat_id){
			return $options;
		}else{
			if(empty($options[$spec_cat_id])){
				return array();
			}
			
			$spec_cat_id_level = $options[$spec_cat_id]['level'];
			
			foreach($options as $key=>$value){
				if($key != $spec_cat_id){
					unset($options[$key]);
				}else{
					break;
				}
			}
			
			$spec_cat_id_array = array();
			foreach($options as $key=>$value){
				if(($spec_cat_id_level == $value['level'] && $value['cat_id'] != $spec_cat_id) || ($spec_cat_id_level > $value['level'])){
					break;
				}else{
					$spec_cat_id_array[$key] = $value;
				}
			}
			$cat_options[$spec_cat_id] = $spec_cat_id_array;
			
			return $spec_cat_id_array;
		}
	}
}
?>