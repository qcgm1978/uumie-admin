<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
/*
**礼物道具控制器
*/
class GiftController extends Controller{
	
	/*
	*礼物列表
	*/
	
	public function actionList(){

		$arr = $this->_catList();

		if (Yii::app()->request->isAjaxRequest){
			$where = " 1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			
			
			if (Yii::app()->request->getParam('catpye')) {
				$where .= " and gift_cat = '".Yii::app()->request->getParam('catpye')."'";
			}
			if (Yii::app()->request->getParam('giftype')) {
				$where .= " and gift_type = '".trim(Yii::app()->request->getParam('giftype'))."'";
			}
			if (Yii::app()->request->getParam('gift_name')) {
				$where .= " and gift_name LIKE '%".trim(Yii::app()->request->getParam('gift_name'))."%'";
			}
							
			
			$order = 'ORDER BY gift_id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT  gift_id, gift_name, gift_price, gift_unit, gift_cat, gift_type, sort_order, is_hidden, is_vie, show_url FROM {{gift}} where ".$where.$order."limit "."$start,". PAGE_NUMBER; 			

			$numbers = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) AS num FROM {{gift}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($numbers as $k => $v) {
				
				$numbers[$k]['gift_cat'] = $arr[$v['gift_cat']];
				$numbers[$k]['operate'] = '<a href="'.$this->createUrl("gift/add",array('giftid'=>$v['gift_id'])).'">编辑</a> | <span style="cursor:pointer;color:#0088cc" onClick="del('.$v['gift_id'].',6,6'.')">删除</span>';
				$numbers[$k]['is_hidden'] = $v['is_hidden'] ? '<span style="cursor:pointer" onClick="recommed('.$v['gift_id'].',0,5'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="recommed('.$v['gift_id'].',1,5'.')"><i class="icon-remove"></i></span>';
			}

			if($page > $pageCount) $page = $pageCount;

			$numbers = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$numbers);
			
			echo CJSON::encode($numbers);

		}else{
			$data = array(
				'info'=>$arr,
				);
			
			$this->render('list',$data);
		}
		
	}
	public function actionUploadImg(){

		if (!empty($_FILES)) {
            //得到上传的临时文件流
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $fileName = $_FILES["Filedata"]["name"];
            // p($_FILES); 
            $path=Yii::getPathOfAlias('webroot')."/upload/";
            $name = trim();
            if (strstr(getExtension($fileName), '.sw')) {
            	$status = 1;
            	$path = $path.'flash/';
            }else{
            	$status = 0;
            }
            
			if (!is_dir($path)) {
			    mkdir($path, 0755, true);
			}
			$fileName = randomStr().getExtension($fileName);

            if (move_uploaded_file($tempFile, $path . $fileName)) {
                if (!$status) {
                	$key = 'images';
                	set_time_limit(0);
               		$img = $path.$fileName;
                    $thumb = generateThumb($img,GIFT_THUMB_IMAGES_WIDTH,GIFT_THUMB_IMAGES_HEIGTH,THUMB_PATH);
                }else{
                	$key = 'flash';
                }
                echo json_encode(array("status" => 0, "info" => "ok", $key => $fileName, "thumb" => $thumb));
                
            } else {

                echo json_encode(array("status" => 1, "info" => $fileName . "上传失败！"));
            }
        }
    }
    //核对礼物是否存在
	public function actionCheckGiftName(){

		if (Yii::app()->request->isAjaxRequest) {
			
			if (Gift::model()->giftNameExists(Yii::app()->request->getParam('giftname'))) {
				echo CJSON::encode(array(1));
			}else{
				echo CJSON::encode(array(0));
			}
		}

	}
	//添加 编辑礼物
	public function actionAdd(){

		if (Yii::app()->request->isAjaxRequest) {
			$giftInfo = new Gift();
			$giftInfo->gift_name = $data['gift_name'] = trim(Yii::app()->request->getParam('giftname'));
			$giftInfo->gift_price = $data['gift_price'] = trim(Yii::app()->request->getParam('gifprice'));
			$giftInfo->gift_unit = $data['gift_unit'] = trim(Yii::app()->request->getParam('giftunit'));
			$giftInfo->gift_cat = $data['gift_cat'] = trim(Yii::app()->request->getParam('catype'));
			$giftInfo->gift_type = $data['gift_type'] = Yii::app()->request->getParam('giftype');
			$giftInfo->gift_img = $data['gift_img'] = trim(Yii::app()->request->getParam('images'));
			$giftInfo->gift_thumb_img = $data['gift_thumb_img'] = trim(Yii::app()->request->getParam('thumb'));
			$giftInfo->gift_swf = $data['gift_swf'] = trim(Yii::app()->request->getParam('flash'));
			$giftInfo->gift_swf_life = $data['gift_swf_life'] = trim(Yii::app()->request->getParam('giftlife'));
			$giftid = trim(Yii::app()->request->getParam('giftid'));
			if ($giftid) {
				
				if (Gift::model()->updateByPk($giftid, $data)) {
					echo CJSON::encode(array(3));
				}else{
					echo CJSON::encode(array(2));
				}
				
			}else{
				if ($giftInfo->save()) {

					echo CJSON::encode(array(1));
				}else{

					echo CJSON::encode(array(0));
				}
			}

		}else{
			$giftid = $_REQUEST['giftid'];
			$giftInfo = Gift::model()->getGiftInfo($_REQUEST['giftid']);
			$data = array(
				'info'=>$this->_catList(),
				'giftid'=>$giftInfo['gift_id'],
				'giftname'=>$giftInfo['gift_name'],
				'giftprice'=>$giftInfo['gift_price'],
				'giftunit'=>$giftInfo['gift_unit'],
				'giftlife'=>$giftInfo['gift_swf_life'],
				'giftimg'=>$giftInfo['gift_img'],
				'giftthumb'=>$giftInfo['gift_thumb_img'],
				'giftswf'=>$giftInfo['gift_swf'],
				'giftcat'=>$giftInfo['gift_cat'],
				'gifttype'=>$giftInfo['gift_type'],
				);

			$this->render('add',$data);
		}		
		
	}
	
	public function actionUpdateInfo(){
		if (Yii::app()->request->isAjaxRequest) {

			$giftid = Yii::app()->request->getParam('giftid');
			$status = Yii::app()->request->getParam('status');
			$type = Yii::app()->request->getParam('type');

			$giftid = "(".$giftid.")";
			// echo $giftid;exit();
			switch ($type) {
				
				case '1':
					$data = array('gift_name'=>$status);
					break;
				case '2':
					$data = array('gift_price'=>$status);
					break;
				case '3':
					$data = array('gift_unit'=>$status);
					break;
				case '4':
					$data = array('sort_order'=>$status);
					break;
				case '5':
					$data = array('is_hidden'=>$status);
					break;								
			}
			if ($type == 6) {
				
				if (Gift::model()->deleteAll('gift_id in '.$giftid)) {

					echo CJSON::encode(array(2));

				}

			}else{
				
				if (Gift::model()->updateAll($data,'gift_id in'.$giftid)) {

					echo CJSON::encode(array(1));

				}else{

					echo CJSON::encode(array(0));
				}
			}
			
		}

	}
	public function actionCharm(){
		if (Yii::app()->request->isAjaxRequest) {
			$where = "1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');

			$page = $page ? $page : 1;
			
			$order = 'ORDER BY star_id ASC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT * FROM {{user_star}} where ".$where.$order."limit "."$start,". PAGE_NUMBER;
			// echo $sql;exit();
			$charmInfo = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) as num FROM {{user_star}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($charmInfo as $k => $v) {

				$charmInfo[$k]['star_id'] = '<img src="/images/star/s'.$v['star_id'].'.png" align="absmiddle">';
				$charmInfo[$k]['star_name'] = '<span title="点击修改" style="cursor:pointer;" class="listorder" onClick="modifyinfo('.$v['star_id'].',1'.')">'.$v['star_name'].'</span>';
				$charmInfo[$k]['min_points'] = '<span title="点击修改" style="cursor:pointer;" class="listorder" onClick="modifyinfo('.$v['star_id'].',2'.')">'.$v['min_points'].'</span>';

			}

			if($page > $pageCount) $page = $pageCount;

			$charmInfo = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$charmInfo);
			
			echo CJSON::encode($charmInfo);
		}else{
			$this->render('charm');

		}
	}
	//编辑明星升级点数和头衔
	public function actionEdCharm(){
		if (Yii::app()->request->isAjaxRequest) {

			$startid = Yii::app()->request->getParam('startid');
			$status = Yii::app()->request->getParam('status');
			$type = Yii::app()->request->getParam('type');

			$startid = "(".$startid.")";
			// echo $startid;exit();
			switch ($type) {
				
				case '1':
					$data = array('star_name'=>$status);
					break;
				case '2':
					$data = array('min_points'=>$status);
					break;
			}
			if (UserStar::model()->updateAll($data,'star_id in'.$startid)) {

					echo CJSON::encode(array(1));

			}else{

				echo CJSON::encode(array(0));
			}
			
		}

	}
	//座驾管理
	public function actionCar(){

		if (Yii::app()->request->isAjaxRequest) {
			$arr = $this->_catList();
			$where = " 1=1 ";
			
			$page =  (int)Yii::app()->request->getParam('page');
			
			$page = $page ? $page : 1;
			
			if (Yii::app()->request->getParam('carname')) {
				$where .= " AND name LIKE '%'".trim(Yii::app()->request->getParam('carname'))."'";
			}
						
			
			$order = 'ORDER BY id DESC ';
			
			$start = ($page-1)* PAGE_NUMBER;
			
			$sql = "SELECT  id, name, price, expire_time, sort_order, is_hidden,type FROM {{car}} where ".$where.$order."limit "."$start,". PAGE_NUMBER; 			

			$numbers = executeSql($sql);

			$sqlCount = "SELECT COUNT(*) AS num FROM {{car}} where ".$where;
			
			$pageCount = executeSql($sqlCount);
			
			$pageCount = ceil($pageCount[0]['num'] /  PAGE_NUMBER);
			
			foreach ($numbers as $k => $v) {

				$numbers[$k]['expire_time'] = formatTimeLimit($v['expire_time']);
				$numbers[$k]['name'] = '<span title="点击修改" style="cursor:pointer;" class="listorder" onClick="modifyinfo('.$v['id'].',1'.')">'.$v['name'].'</span>';
				$numbers[$k]['price'] = '<span title="点击修改" style="cursor:pointer;" class="listorder" onClick="modifyinfo('.$v['id'].',2'.')">'.$v['price'].'</span>';
				$numbers[$k]['sort_order'] = '<span title="点击修改" style="cursor:pointer;" class="listorder" onClick="modifyinfo('.$v['id'].',3'.')">'.$v['sort_order'].'</span>';
				$numbers[$k]['operate'] = '<a href="'.$this->createUrl("gift/addcar",array('carid'=>$v['id'])).'">编辑</a> | <span style="cursor:pointer;color:#0088cc" onClick="del('.$v['id'].',6,6'.')">删除</span>';
				$numbers[$k]['is_hidden'] = $v['is_hidden'] ? '<span style="cursor:pointer" onClick="recommed('.$v['id'].',0,4'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="recommed('.$v['id'].',1,4'.')"><i class="icon-remove"></i></span>';
				$numbers[$k]['type'] = $v['type'] ? '<span style="cursor:pointer" onClick="recommed('.$v['id'].',0,5'.')"><i class="icon-ok"></i></span>' :'<span style="cursor:pointer" onClick="recommed('.$v['id'].',1,5'.')"><i class="icon-remove"></i></span>';
			}

			if($page > $pageCount) $page = $pageCount;

			$numbers = array_merge(array(array('page'=>$page,'pageCount'=>$pageCount)),$numbers);
			
			echo CJSON::encode($numbers);
		}else{

			$this->render('car');
		}
	}
	
	public function actionCarInfo(){
		if (Yii::app()->request->isAjaxRequest) {

			$carid = Yii::app()->request->getParam('carid');
			$status = Yii::app()->request->getParam('status');
			$type = Yii::app()->request->getParam('type');

			// $carid = "(".$carid.")";
			// echo $carid;exit();
			switch ($type) {
				
				case '1':
					$data = array('name'=>$status);
					break;
				case '2':
					$data = array('price'=>$status);
					break;
				case '3':
					$data = array('sort_order'=>$status);
					break;
				case '4':
					$data = array('is_hidden'=>$status);
					break;
				case '5':
					$data = array('type'=>$status);
					break;								
			}
			if ($type == 6) {
				
				if (Car::model()->deleteByPk($carid)) {

					echo CJSON::encode(array(2));

				}

			}else{

				if (Car::model()->updateByPk($carid,$data)) {

					echo CJSON::encode(array(1));

				}else{

					echo CJSON::encode(array(0));
				}
			}
			
		}

	}
	//添加 编辑礼物
	public function actionAddCar(){

		if (Yii::app()->request->isAjaxRequest) {
			$carInfo = new Car();
			$carInfo->name = $data['name'] = trim(Yii::app()->request->getParam('carname'));
			$carInfo->price = $data['price'] = trim(Yii::app()->request->getParam('carprice'));
			$carInfo->expire_time = $data['expire_time'] = trim(Yii::app()->request->getParam('carexpiretime'))*24*3600;
			$carInfo->img = $data['img'] = trim(Yii::app()->request->getParam('images'));
			$carInfo->thumb_img = $data['thumb_img'] = trim(Yii::app()->request->getParam('thumb'));
			$carInfo->swf = $data['swf'] = trim(Yii::app()->request->getParam('flash'));
			$carInfo->swf_life = $data['swf_life'] = trim(Yii::app()->request->getParam('carlife'));
			$carid = trim(Yii::app()->request->getParam('carid'));
			if ($carid) {
				
				if (Car::model()->updateByPk($carid, $data)) {
					echo CJSON::encode(array(3));
				}else{
					echo CJSON::encode(array(2));
				}
				
			}else{
				if ($carInfo->save()) {

					echo CJSON::encode(array(1));
				}else{

					echo CJSON::encode(array(0));
				}
			}

		}else{
			$carid = $_REQUEST['carid'];
			$carInfo = Car::model()->getCarInfo($_REQUEST['carid']);
			$data = array(
				'carid'=>$carInfo['id'],
				'carname'=>$carInfo['name'],
				'carprice'=>$carInfo['price'],
				'carexpiretime'=>formatTimeLimit($carInfo['expire_time']),
				'carlife'=>$carInfo['swf_life'],
				'carimg'=>$carInfo['img'],
				'carthumb'=>$carInfo['thumb_img'],
				'carswf'=>$carInfo['swf'],
				);

			$this->render('addcar',$data);
		}		
		
	}
	public function _catList(){
		return array(
			'1'=>'普通',
			'2'=>'精品',
			'3'=>'豪华',
			'4'=>'奢侈',
			'5'=>'浪漫',
			'6'=>'逗趣'
			);
		}
	public function filters(){
		return array(
				'accessControl',
			);
	}
	function accessRules() {
        return array(
            array(
                'allow',
                'actions'=>array('list','uploadimg','checkgiftname','updateinfo','edcharm','add','charm','car','carinfo','addcar'),
                'users'=>array('@'),
            ),
            array(
                'deny',
                'users'=>array('*'),
            ),
        );
    }	
}
?>