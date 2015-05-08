<?php
/*
* 管理员模型
*/
class Admin extends CActiveRecord{

	/*
	*返回模型
	*/

	public static function model($className = __CLASS__){

		return parent::model($className);
		
	}
	public function tableName(){
		return "{{admin}}";
	}
	
    /**
     * 判断是否是管理员
     *
     * @param string $username
     * @return 如果是管理员，返回改管理的相关信息，否则返回 false
     */
    public function isAdmin($uid){
        $criteria=new CDbCriteria;  
        $criteria->select='action_list';  
        $criteria->condition='uid=:uid';
        $criteria->params=array(':uid'=>$_SESSION['uid']);  
        $criteria->order='uid DESC';  
        $result = $this->find($criteria);
        return !empty($result) ?  $result['action_list'] : '';

    }
}
?>