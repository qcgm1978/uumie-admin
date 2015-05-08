<?php

/*
 * 设置系统变量信息
 * 
 */
define('UID_MAX_LENGHT', 99999999);                           // UID最大长度,用于判断是否是游客
define('GID_MAX_LENGHT', 9999999);                            // GID最大长度,用于判断是否是靓号

//每页的数量
define('PAGE_NUMBER', 15); 
 
define('IMG_PATH',"./upload/screenshot/");//图片路径
// 用户权限
define('USER_WATCHMAN_LIMITS',           6000); // 巡查
define('USER_AREA_LIMITS_A',             5000); // 大区管
define('USER_AREA_LIMITS_B',             4000); // 区管
define('USER_AREA_LIMITS_C',             3000); // 副区管
define('USER_ROOM_LIMITS_A',             2000); // 房主
define('USER_ROOM_LIMITS_B',             1000); // 副房主
define('USER_ROOM_LIMITS_C',             900);  // 房间管理员
define('USER_MEMBER_LIMITS',             100);  // 普通会员
define('USER_GUEST_LIMITS',              1);    // 游客

define('GIFT_THUMB_IMAGES_WIDTH', 50); //缩略图的宽
define('GIFT_THUMB_IMAGES_HEIGTH', 50); //缩略图的高
define('THUMB_PATH', 'thumb'); //缩略图的高

 ?>