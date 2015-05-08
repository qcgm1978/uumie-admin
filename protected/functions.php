<?php 
	/**
	 * 格式化打印函数
	 */
	function p($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
	function exportPhpExcel($title,$header,$result){
		ini_set('memory_limit','512M');
		// p($header);
		$infos = array_keys($header);
		$header = headerFormat($header);
		
		$objectPHPExcel = new PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
		$len = count($header);
		// $current_page = 1;
		// $page_count = 20;
		$end = digital2letters($len-1);
		$lennum = 'A1:'.$end.'1';

		$info = array_keys($header);

		//报表头的输出
		$objectPHPExcel->getActiveSheet()->mergeCells($lennum);
		$objectPHPExcel->getActiveSheet()->setCellValue('A1',$title);
		$objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$title);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$title);
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(24);
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle('A1')
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','日期：'.date("Y年m月j日"));
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle($end.'2')
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        // $objectPHPExcel->setActiveSheetIndex(0)->setCellValue($end.'2','第'.$current_page.'/'.$page_count.'页');
        $objectPHPExcel->setActiveSheetIndex(0)->getStyle($end.'2')
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        foreach ($header as $k => $v) {
            $objectPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(20);
        	$objectPHPExcel->setActiveSheetIndex(0)->setCellValue($k.'3',$v);
        }    
        //设置居中
        $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3')
            ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //设置边框
        $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
            ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
            ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
            ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
            ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
            ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //设置颜色
        $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3')->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');
        
        $m = 4; 

      	foreach ($result as $k1 => $v1) {

      		//循环输出表的值
      		foreach ($infos as $k2=> $v2) {
      			
     			$objectPHPExcel->getActiveSheet()->setCellValue(digital2letters($k2).$m,$v1[$v2]);
      		}

      		$m++;
      	}
      	// var_dump($objectPHPExcel);exit();


   
        //设置分页显示
        //$objectPHPExcel->getActiveSheet()->setBreak( 'I55' , PHPExcel_Worksheet::BREAK_ROW );
        //$objectPHPExcel->getActiveSheet()->setBreak( 'I10' , PHPExcel_Worksheet::BREAK_COLUMN );
        // $objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        // $objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
   
        ob_end_clean();
        ob_start();
   		header("Content-Type: application/force-download"); 
  		header("Content-Type: application/octet-stream"); 
    	header("Content-Type: application/download"); 
        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$title.'-'.date("Y年m月j日").'.csv"');
        $objWriter= PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
		// p($objWriter);exit();       
        $objWriter->save('php://output'); 
	}

	function executeSql($sql){

		return yii::app()->db->createCommand($sql)->queryAll();
	}
	/**
	 * 获得用户的真实IP地址
	 *
	 * @access  public
	 * @return  string
 */

	function userRealIp() {
		static $realip = NULL;
		if($realip !== NULL){
			return $realip;
		}
		if(isset($_SERVER)){
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				/* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
				foreach($arr as $ip){
					$ip = trim($ip);
					if($ip != 'unknown'){
						$realip = $ip;
						break;
					}
				}
			}elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			}else{
				if(isset($_SERVER['REMOTE_ADDR'])){
					$realip = $_SERVER['REMOTE_ADDR'];
				}else{
					$realip = '0.0.0.0';
				}
			}
		}else{
			if(getenv('HTTP_X_FORWARDED_FOR')){
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			}elseif(getenv('HTTP_CLIENT_IP')){
				$realip = getenv('HTTP_CLIENT_IP');
			}else{
				$realip = getenv('REMOTE_ADDR');
			}
		}
		
		preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
		$realip = ! empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
		return $realip;
	}

	//产生虚拟人数组
	function makeVirusersList($room_id, $users_sum, $guest_sum, $lifetime){

		// 计算会员数组
		$users  = array();
		if ($users_sum){
			$sql = "SELECT uid, username FROM {{user_virtual}} ORDER BY rand() LIMIT $users_sum";

			$res = Yii::app()->db->createCommand($sql)->queryAll();
			
			foreach ($res as $v){
				$ltime = 60;
			
				$ltime = $lifetime > 60 ? mt_rand($lifetime, $lifetime * 2) : 60;
				$obj = getUserpara($v['uid'],$room_id);
					echo $v['uid'];exit();
				if ($obj['roomer']==1 || $obj['agency']>=1 || $obj['watchman']>=1 || $obj['levelinroom']>100){
					continue;
				}
				$users[] = "+ $room_id $v[uid] 100 ". base64_encode(json_encode($obj)) ." $ltime";
			}
			
		}
		// 计算游客数组
		// $guests = array();
		// if ($guest_sum){
		// 	for($i=0; $i < $guest_sum; $i++){
		// 		$ltime = 60;
		// 		$guest_number   = guest_number();
		// 		$guset_username = '游客' . substr($guest_number, -4);
		// 		$ltime = $lifetime > 60 ? mt_rand($lifetime, $lifetime * 2) : 60;
		// 		// $obj = build_guest_userpara($guest_number,$guset_username);
		// 		$guests[] = "+ $room_id $guest_number 1 " . base64_encode(json_encode($obj)) ." $ltime";
		// 	}
		// }
		// $all = array();
		// $all = array_merge($users, $guests);

		// return _iconv('utf-8' , 'gb2312', implode('|', $all));
	}
	// 格式化用户对象
	function getUserpara($uid, $roomid){

	    $user_info = getUserInfo($uid);
	    // p($user_info);   
	    // 角色
	    // echo $uid;
		$role = getUserRole($uid, $roomid);  
		UserStar::model()->getUserStar($uid);
		p($role);exit();
	    $data = array(
			'uid'		=> 	intval($uid),
			'gid'		=> 	intval($uid),
			'nicegid'		=> 	intval(User::model()->getUserNicegid($uid)),
	        'icon'        => intval($user_info['icon']) ,                                    // 头像
	        'vip'         => intval(UserVip::model()->isVip($uid)),                         // 是否VIP
	    	'vip2'         => intval(UserVipVip::model()->isVip2($uid)),                         // 是否VIP
	        'badge'       => intval(UserVipVip::model()->userBadgeId($uid)) ,                 // 印章ID
	        'levelinroom' => intval(userRoomLimits($uid, $roomid)) ,    // 在房间中的权限
	        'title'       => intval(UserTitle::model()->userBadgeId($uid)),                 // 爵位
	        'role'        => $role,
			'agency'	  => $role & 128,
			'watchman'	  => $role & 8,	
			'roomer'	  => $role & 4,
			'starlevel'	  => intval(UserStar::model()->getUserStar($uid)),
			'chatdisable' => $GLOBALS['room']->checkChatdisable($roomid,$uid),
			'nickname_b64'	=> 	base64_encode($user_info['nickname']),
	    	'car_id' => intval($GLOBALS['user']->get_user_carid($uid)),
	    	'family_name' => base64_encode($GLOBALS['user']->get_user_familyname($uid)),
	    );
	    return $data;
	}
	function getUserInfo($uid){
		
		$result = array();

		$sql = "SELECT  f.uid,f.name,f.icon,f.sex,f.email,f.birth,f.qq,f.sign,f.avatar,f.email_status,u.username,u.gid,v.vip_id,a.coin,IFNULL(f.nickname,u.username) AS nickname from {{user}} u LEFT JOIN {{user_fields}} f ON f.uid = u.uid  LEFT JOIN {{user_vip}} v ON v.uid = u.uid LEFT JOIN {{user_account}} a ON a.uid= u.uid where u.uid='".$uid."'";
		// $result = Yii::app()->db->createCommand($sql)->queryAll();
		$info = Yii::app()->db->createCommand($sql)->queryAll();

		foreach ($info as $key => $value) {
			$result = $value;
		}
		return $result;
	}
	function roomLimitType($uid, $roomid){
		

		$criteria=new CDbCriteria;  
		$criteria->select='type'; 
		$criteria->condition='uid=:uid AND room_id=:roomid';
		$criteria->params=array(':uid'=>$uid,':roomid'=>$roomid);  
		$criteria->order='uid DESC';  
		
		$type = RoomLimits::model()->find($criteria);
		
		return $type['type'] ? $type['type'] : '0';

	}
	function isAgency($uid){
		
		$criteria=new CDbCriteria;  
		$criteria->select='uid';  
		$criteria->condition='uid=:uid';
		$criteria->params=array(':uid'=>$uid);  
		$criteria->order='uid DESC';  
		$agency=Agency::model()->find($criteria);

		return $agency['uid'];

	}
	/* 用户是否是巡管*/
	function isWatchman($uid){

    	$criteria=new CDbCriteria;  
		$criteria->select='uid';  
		$criteria->condition='uid=:uid';
		$criteria->params=array(':uid'=>$uid);  
		$criteria->order='uid DESC';  
		$watchman=RoomWatchman::model()->find($criteria);
		// p($watchman);exit();
    	return !empty($watchman) ? 1 : 0;
    }
    function areamanType($uid, $room_id){
    	$result = array();
    	$type = '';
    	$sql = "select m.type from {{room_category_manager}} m left join {{room}} r on r.cat_id = m.cat_id where r.room_id='".$room_id."' and m.uid='".$uid."'";
    	$info = Yii::app()->db->createCommand($sql)->queryAll();
    	foreach ($info as $value) {
    		$result = $value;
    	}
    	if (!empty($result)) {
    		foreach ($result as $k => $v) {
    			$type = $v['type'];
    		}
    	}

    	return $type? intval($type) : 0;
    }
     /* 是否是主播 */
    function isStar($uid, $room_id){

    	return 0;
    }

	/* 获取用户在权限的角色 */
   function getUserRole($uid, $room_id){
    	// 代理
    	$agency = 0;
    	$room_limit_type = roomLimitType($uid, $room_id);
    	// p($room_limit_type);exit();
		if (isAgency($uid) && ($room_limit_type == 1 || $room_limit_type == 2) ){
			$agency = 128;
		}

		// 其他角色
    	$other = 0;

    	// 判断是否是巡管
    	if(isWatchman($uid)){

    		return $agency | 8;

    	}else if( $areaman = areamanType($uid, $room_id) ){

    	// 是否是区管
    		if ($areaman == 1){$other = 64;} // 大区
    		if ($areaman == 2){$other = 32;} // 正区
    		if ($areaman == 3){$other = 16;} // 富区
    		return $agency | $other;
    	}else if ($roomlimit = roomLimitType($uid, $room_id)){
    	// 是否是房主
    		if ($roomlimit == 1){$other = 4;} // 房主
    		if ($roomlimit == 2){$other = 2;} // 副房主
    	
    		return $agency | $other;
    	} else if (isStar($uid, $room_id)){
    	// 是否是主播
     	
     		$other = 1;
     		return $agency | $other;
     	}else{
     	//普通角色
     		return $agency | 0;
     	}
    }
    
    /**
     * 获取用户在指定房间中的权限
     *
     * @param int $uid
     * @param int $room_id
     */
    function userRoomLimits($uid, $room_id){

    	
    	// 判断是否是游客
    	if ($uid > UID_MAX_LENGHT)
    	{
    		return USER_GUEST_LIMITS;
    	}
    	else  //如果不是游客，权限由高到底查询
    	{
    		// 巡管
        	if(isWatchman($uid) )
        	{
        		return USER_WATCHMAN_LIMITS;
        	}
	    	// 是否是区管
	    	else if($areaman = areamanType($uid, $room_id) )
	    	{
	    		if ($areaman == 1){return USER_AREA_LIMITS_A;} // 大区
	    		if ($areaman == 2){return USER_AREA_LIMITS_B;} // 正区
	    		if ($areaman == 3){return USER_AREA_LIMITS_C;} // 副区
	    	}
			// 在房间的权限
	    	else if ($type = roomLimitType($uid, $room_id))
	    	{
	    		if ($type == 1){return USER_ROOM_LIMITS_A;} // 房主
	    		if ($type == 2){return USER_ROOM_LIMITS_B;} // 副房主
	    		if ($type == 3){return USER_ROOM_LIMITS_C;} // 房间管理
	    	}
    	    //普通会员权限
       		else
       		{
       			return USER_MEMBER_LIMITS;
       		}
    	}
    }
    /* 将字符串按指定的长度空格 */
	function nStr($str, $n = 4) {

		$str = str_replace(" ", "", makeSemiangle($str));
		$len = strlen($str);
		$i = 0;
		
		for(; $i < $len; $i += $n){
			$arr[$i] = substr($str, $i, $n);
		}
		return implode(" ", $arr);

	}
	/**
	 *  将一个字串中含有全角的数字字符、字母、空格或'%+-()'字符转换为相应半角字符
	 *
	 * @access  public
	 * @param   string      待转换字串
	 *
	 * @return  string      处理后字串
	 */
	function makeSemiangle($str) {
		$arr = array('０'=>'0', '１'=>'1', '２'=>'2', '３'=>'3', '４'=>'4', '５'=>'5', '６'=>'6', '７'=>'7', '８'=>'8', '９'=>'9', 'Ａ'=>'A', 'Ｂ'=>'B', 'Ｃ'=>'C', 'Ｄ'=>'D', 'Ｅ'=>'E', 'Ｆ'=>'F', 'Ｇ'=>'G', 'Ｈ'=>'H', 'Ｉ'=>'I', 'Ｊ'=>'J', 'Ｋ'=>'K', 'Ｌ'=>'L', 'Ｍ'=>'M', 'Ｎ'=>'N', 'Ｏ'=>'O', 'Ｐ'=>'P', 'Ｑ'=>'Q', 'Ｒ'=>'R', 
				'Ｓ'=>'S', 'Ｔ'=>'T', 'Ｕ'=>'U', 'Ｖ'=>'V', 'Ｗ'=>'W', 'Ｘ'=>'X', 'Ｙ'=>'Y', 'Ｚ'=>'Z', 'ａ'=>'a', 'ｂ'=>'b', 'ｃ'=>'c', 'ｄ'=>'d', 'ｅ'=>'e', 'ｆ'=>'f', 'ｇ'=>'g', 'ｈ'=>'h', 'ｉ'=>'i', 'ｊ'=>'j', 'ｋ'=>'k', 'ｌ'=>'l', 'ｍ'=>'m', 'ｎ'=>'n', 'ｏ'=>'o', 'ｐ'=>'p', 'ｑ'=>'q', 'ｒ'=>'r', 'ｓ'=>'s', 'ｔ'=>'t', 
				'ｕ'=>'u', 'ｖ'=>'v', 'ｗ'=>'w', 'ｘ'=>'x', 'ｙ'=>'y', 'ｚ'=>'z', '（'=>'(', '）'=>')', '〔'=>'[', '〕'=>']', '【'=>'[', '】'=>']', '〖'=>'[', '〗'=>']', '“'=>'[', '”'=>']', '‘'=>'[', '’'=>']', '｛'=>'{', '｝'=>'}', '《'=>'<', '》'=>'>', '％'=>'%', '＋'=>'+', '—'=>'-', '－'=>'-', '～'=>'-', '：'=>':', 
				'。'=>'.', '、'=>',', '，'=>'.', '、'=>'.', '；'=>',', '？'=>'?', '！'=>'!', '…'=>'-', '‖'=>'|', '”'=>'"', '’'=>'`', '‘'=>'`', '｜'=>'|', '〃'=>'"', '　'=>' ');
		
		return strtr($str, $arr);
	}
	/**
	 * 导出excel 
	 * @param  string   $title 表标题   $title = 'U美会员列表';  
	 * @param  array    $header 表头 一维数组 		$header = array('name'=>'姓名','age'=>'年龄','sex'=>'性别','tel'=>'手机','love'=>'爱好');
	 * @param  array    $result 内容 二维数组    		$result = array(array('name'=>'姓名','age'=>'年龄','sex'=>'性别','tel'=>'手机','love'=>'爱好'),array('name'=>'姓名','age'=>'年龄','sex'=>'性别','tel'=>'手机','love'=>'爱好'));
	 * @return  string        处理后字串
	 */

	function exportExcel($title,$header,$result){
		ini_set('memory_limit','512M');
		// p($header);
		$infos = array_keys($header);
		$header = headerFormat($header);
		
		$objectPHPExcel = new PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
		$len = count($header);
		// $current_page = 1;
		// $page_count = 20;
		$end = digital2letters($len-1);
		$lennum = 'A1:'.$end.'1';

		$info = array_keys($header);

			//报表头的输出
			$objectPHPExcel->getActiveSheet()->mergeCells($lennum);
			$objectPHPExcel->getActiveSheet()->setCellValue('A1',$title);
			$objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$title);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$title);
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(24);
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle('A1')
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','日期：'.date("Y年m月j日"));
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle($end.'2')
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            // $objectPHPExcel->setActiveSheetIndex(0)->setCellValue($end.'2','第'.$current_page.'/'.$page_count.'页');
            $objectPHPExcel->setActiveSheetIndex(0)->getStyle($end.'2')
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            foreach ($header as $k => $v) {
                $objectPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(20);
            	$objectPHPExcel->setActiveSheetIndex(0)->setCellValue($k.'3',$v);
            }    
            //设置居中
            $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3')
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //设置边框
            $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
                ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
                ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
                ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
                ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3' )
                ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            //设置颜色
            $objectPHPExcel->getActiveSheet()->getStyle('A3:'.$end.'3')->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');
            
            $m = 4; 

          	foreach ($result as $k1 => $v1) {

          		//循环输出表的值
          		foreach ($infos as $k2=> $v2) {
          			
         			$objectPHPExcel->getActiveSheet()->setCellValue(digital2letters($k2).$m,$v1[$v2]);
          		}
          		foreach ($info as $k3=> $v3) {
          			
         			$objectPHPExcel->getActiveSheet()->getStyle(digital2letters($k3).$m.':'.$end.$m)
                    ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          		}

          		$objectPHPExcel->getActiveSheet()->getStyle('A'.$m.':'.$end.$m)
                ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


          		$m++;
          	}
          	// p($objectPHPExcel);exit();


	   
	        //设置分页显示
	        //$objectPHPExcel->getActiveSheet()->setBreak( 'I55' , PHPExcel_Worksheet::BREAK_ROW );
	        //$objectPHPExcel->getActiveSheet()->setBreak( 'I10' , PHPExcel_Worksheet::BREAK_COLUMN );
	        $objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
	        $objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
	   
	        ob_end_clean();
	        ob_start();
	   		header("Content-Type: application/force-download"); 
      		header("Content-Type: application/octet-stream"); 
        	header("Content-Type: application/download"); 
	        header('Content-Type : application/vnd.ms-excel');
	        header('Content-Disposition:attachment;filename="'.$title.'-'.date("Y年m月j日").'.csv"');
	        $objWriter= PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
	        $objWriter->save('php://output'); 
	}

	function headerFormat($header){
		
		$n = 0;
		foreach ($header as $k => $v) {

			$result[digital2letters($n)] = $v;
			$n++;
		}
		return $result;
	}
	function digital2letters($key){

		$letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

		return $letter[$key];
	}
	
	function mysqlLikeQuote($str) {

		return strtr($str, array("\\\\"=>"\\\\\\\\", "_"=>"\\_", "%"=>"\\%", "\\'"=>"\\\\\\'"));
	
	}
	//生成随机的字符串
	function randomStr(){
		$str = '';
		for($i = 0; $i < 9; $i ++){
			$str .= mt_rand(0, 9);
		}	
		return time() . $str;
	}
	//获取文件后缀名
	function getExtension($filename){
		return '.'.pathinfo($filename,PATHINFO_EXTENSION);
	}
	//生成缩略图
	function  generateThumb($img, $thumb_width = 0, $thumb_height = 0, $path = '', $bgcolor = ''){
		$gd = gdVersion(); //获取 GD 版本。0 表示没有 GD 库，1 表示 GD 1.x，2 表示 GD 2.x

		$org_info = @getimagesize($img);
		$img_org = imgResource($img, $org_info[2]);
		$scale_org = $org_info[0] / $org_info[1];
		if($thumb_width == 0){
			$thumb_width = $thumb_height * $scale_org;
		}
		if($thumb_height == 0){
			$thumb_height = $thumb_width / $scale_org;
		}
		if($gd == 2){
			$img_thumb = imagecreatetruecolor($thumb_width, $thumb_height);
		}else{
			$img_thumb = imagecreate($thumb_width, $thumb_height);
		}

		/* 背景颜色 */
		if(empty($bgcolor)){
			$bgcolor = "#FFFFFF";
		}
		$bgcolor = trim($bgcolor, "#");
		sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
		$clr = imagecolorallocate($img_thumb, $red, $green, $blue);
		imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr);
		
		if($org_info[0] / $thumb_width > $org_info[1] / $thumb_height){
			$lessen_width = $thumb_width;
			$lessen_height = $thumb_width / $scale_org;
		}else{
			/* 原始图片比较高，则以高度为准 */
			$lessen_width = $thumb_height * $scale_org;
			$lessen_height = $thumb_height;
		}
		
		$dst_x = ($thumb_width - $lessen_width) / 2;
		$dst_y = ($thumb_height - $lessen_height) / 2;
		
		/* 将原始图片进行缩放处理 */
		if($gd == 2){
			imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
		}else{
			imagecopyresized($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);
		}
		if(empty($path)){
			$dir=Yii::getPathOfAlias('webroot')."/upload/". date('Ym') . '/';
		}else{
			$dir=Yii::getPathOfAlias('webroot')."/upload/". $path . '/';
		}
		// p($dir);
		/* 如果目标目录不存在，则创建它 */
		if(! file_exists($dir)){
			if(!mkdir($dir, 0755, true)){
				/* 创建目录失败 */
				return false;
			}
		}
		// p($dir);exit();
		$fileName = randomStr().getExtension($img,1);
		// p($fileName);
		/* 生成文件 */
		if(function_exists('imagejpeg')){
			
			imagejpeg($img_thumb, $dir . $fileName);
		}elseif(function_exists('imagegif')){
			
			imagegif($img_thumb, $dir . $fileName);
		}elseif(function_exists('imagepng')){
			
			imagepng($img_thumb, $dir . $fileName);
		}else{			
			return "创建图片失败";
		}
		imagedestroy($img_thumb);
		imagedestroy($img_org);

		if(file_exists($dir . $fileName)){
			return $fileName;
		}else{
			return false;
		}

	}
	/**
	 * 根据来源文件的文件类型创建一个图像操作的标识符
	 *
	 * @access  public
	 * @param   string      $img_file   图片文件的路径
	 * @param   string      $mime_type  图片文件的文件类型
	 * @return  resource    如果成功则返回图像操作标志符，反之则返回错误代码
	 */
	function imgResource($img_file, $mime_type) {
		switch ($mime_type){
			case 1:
			case 'image/gif':
				$res = imagecreatefromgif($img_file);
				break;
			
			case 2:
			case 'image/pjpeg':
			case 'image/jpeg':
				$res = imagecreatefromjpeg($img_file);
				break;
			
			case 3:
			case 'image/x-png':
			case 'image/png':
				$res = imagecreatefrompng($img_file);
				break;
			
			default:
				return false;
		}
		
		return $res;
	}
	/**
	 * 获得服务器上的 GD 版本
	 *
	 * @access      public
	 * @return      int         可能的值为0，1，2
	 */
	function gdVersion() {
		static $version = - 1;
		
		if($version >= 0){
			return $version;
		}
		
		if(! extension_loaded('gd')){
			$version = 0;
		}else{
			// 尝试使用gd_info函数
			if(PHP_VERSION >= '4.3'){
				if(function_exists('gd_info')){
					$ver_info = gd_info();
					preg_match('/\d/', $ver_info['GD Version'], $match);
					$version = $match[0];
				}else{
					if(function_exists('imagecreatetruecolor')){
						$version = 2;
					}elseif(function_exists('imagecreate')){
						$version = 1;
					}
				}
			}else{
				if(preg_match('/phpinfo/', ini_get('disable_functions'))){
					/* 如果phpinfo被禁用，无法确定gd版本 */
					$version = 1;
				}else{
					// 使用phpinfo函数
					ob_start();
					phpinfo(8);
					$info = ob_get_contents();
					ob_end_clean();
					$info = stristr($info, 'gd version');
					preg_match('/\d/', $info, $match);
					$version = $match[0];
				}
			}
		}
		
		return $version;
	}
	//格式化时间
	function formatTimeLimit($time){

		if ($time == 2147483647){
			$limit = '永久有效';
		}else{
			$limit = intval($time / (3600 * 24));
		}
		return $limit;
	}

	//判断用户名的长度
	function nameLen($username){
		//非全部汉字
		if(preg_match("/^[a-z\d]*$/i", $username)) {

	        if($username && (strlen($username) > 16 || strlen($username) < 2)){
	        	return '1';
	        }
	    }else{
	    	//全部汉字
	        if($username && (strlen($username) > 24 || strlen($username) < 2)){

	        	return '1';
	    	}
	    }
	    // 账号中含有特殊字符
		if (preg_match("/(<|>|&|'|\|\s|\"|　)/u", $username)){
			
			return '2';
		}else{
			return '3';
		}

	}
	/**
	 * 生成新订单号
	 * @return  string
	 */
	function getOrderSn() {
		$rand24 = mt_rand(10000000, 99999999) . mt_rand(10000000, 99999999) . mt_rand(10000000, 99999999);
		$rand8 = substr($rand24, mt_rand(0, 16), 8);
		return date('ymd') . str_pad($rand8, 8, '0', STR_PAD_LEFT);
	}
	/**
	 * 检查管理员权限，返回JSON格式数剧
	 *
	 * @access  public
	 * @param   string  $authz
	 * @return  void
	 */
	function checkAuthzJson($authz) {
		return !checkAuthz($authz) ? false :true;
	}
	/**
	 * 检查管理员权限
	 *
	 * @access  public
	 * @param   string  $authz
	 * @return  boolean
	 */
	function checkAuthz($authz) {
		
		return (preg_match('/,*' . $authz . ',*/', $_SESSION['action_list']) || $_SESSION['action_list'] == 'all');
	}
	//导出csv
	function export_csv($filename,$title,$data,$proto=array(),$path=null,$page=1,$pagesize = 0) {

		if(!$data) {
		 	header("Content-Type: text/html; charset=utf-8");
    		exit('导出数据为空');
    	}

		$filename1 = $filename;
    	if(empty($filename)){
    		$filename = 'export'.date('m-d_H-i-s',time()).'.csv';	//导出文件名称
			$filename1 = $filename;
    	}else{
    		$filename = charseticonv($filename);
    		if(!strpos($filename,".csv")){
    			$filename = $filename.'.csv';
    		}
    	}
// exit();

    	//输出流
		header("Content-Type:application:text/csv;charset=UTF-8");
		header('Content-Disposition:attachment;filename="'.$filename.'"'); 
		// header("Content-Type: application/force-download");
		// // header("Content-Type:application:text/csv;charset=UTF-8");
		// header('Content-Disposition:attachment;filename="'.$filename.'"');
		// header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
  // 	 	header('Expires:0');
  //  	 	header('Pragma:public');

		if($path) {//有传入文件路径时导出为文件
			$out = fopen($path.$filename1.".csv","a+");
		}
		else {
			$out = fopen('php://output', 'w+');
			// Yii::app()->end();

		}
		//导出标题, 编码转换, 加一列序号

    	foreach($title as $value){
    		$dtitle[] = $value['name'];
    	}
		//导出标题, 编码转换, 加一列序号
		array_unshift($dtitle,'序号');
	    $dtitle = charseticonv($dtitle);
		if($page == 1) fputcsv($out, $dtitle);//页数大于第一页时不写表头

		//导出内容
		if($page > 1 && $pagesize > 0) $i = ($page - 1) * $pagesize + 1;//页数大于第一页时处理序号 
		else $i = 1;
		foreach($data as  $value) {
	        $tmpval = array();
	        $tmpval[] = $i;
	        //列
	        $j = 1;
			foreach($title as $key=>$sv) {
				$val = '';
				if(is_object($value)){
					$val = $value->$key;
				}
				if(is_array($value)){
					$val = $value[$key];
				}
				if(in_array($j,$proto)) $val = '="'.$val.'"';
	            $tmpval[] = $val;
	            $j++;
	        }
	        //编码转换
	        $tmpval = charseticonv($tmpval);
	        // p($tmpval);exit();
	        fputcsv($out, $tmpval);

	        $i++;

	    }
	    
	    unset($data);
		if($path) return;//导出为文件的时候返回
		else exit();
	}
	function charseticonv($str,$char='gbk') {
		if(is_array($str)) {
			foreach ($str as $k=>$v) {
				$str[$k] = charseticonv($v,$char);
			}
		} else {
			if($char=='gbk') {
				$str = 	iconv('utf-8','gbk',trim($str));
			} else {
				$str = 	iconv('gbk','utf-8',trim($str));
			}
		}
		return $str;
	}


 ?>