<?php
/*
* 违规管理模型
*/
class Violation extends CActiveRecord{

    /*
    *返回模型
    */
    public static function model($className = __CLASS__){

        return parent::model($className);

    }
    public function tableName(){
        return "{{violation}}";
    }


}
?>