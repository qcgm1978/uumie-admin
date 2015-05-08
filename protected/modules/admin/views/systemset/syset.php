<div class="span10">
<h4 class="page-title">系统设置</h4>
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">基本设置</a></li>
      <li><a href="#profile" data-toggle="tab">比例设置</a></li>
      <li ><a href="#show" data-toggle="tab">显示设置</a></li>
      <li><a href="#api" data-toggle="tab">API设置</a></li>
    </ul>
    <input type="hidden" id="param" value="<?php echo $param ?>">
    <input type="hidden" id="url" value="<?php echo $this->createUrl("systemset/syset") ?>">
 <form>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
         
          <?php $room_min_user = explode('_', $room_min_user); ?> 
              <label id="<?php echo $room_min_user[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间最大人数：
                  <select id="room_min_user"  name="room_min_user" class="input-sm">
                    <option value="10">10人</option>
                    <option value="50">30人</option>
                    <option value="30">30人</option>
                    <option value="500">500</option>
                   </select>
              </label>
              <input type="hidden" id="minuser"  value="<?php echo $room_min_user[1] ?>"  /> 
              <?php $upload_url = explode('_', $upload_url); ?>    
              <label id="<?php echo $upload_url[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              图片文件下载地址：<input type="text" id="upload_url" name="upload_url" value="<?php echo $upload_url[1] ?>" class="input-sm"></label>
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              上传文件大小限制：
              <?php $upload_size_limit = explode('_', $upload_size_limit); ?>
                  <select  id="upload_size_limit" name="upload_size_limit" class="input-sm">
                     <option value="-1">服务默认设置</option>
                     <option value="0">0KB</option>
                     <option value="64">64KB</option>
                     <option value="128">128KB</option>
                     <option value="256">256KB</option>
                     <option value="512">512KB</option>
                     <option value="1024">1MB</option>
                     <option value="2048">2MB</option>                    
                   </select>
              </label>
              <input type="hidden" id="upzl" value="<?php echo $upload_size_limit[1] ?>"  /> 
               <?php $gift_broadcast_base = explode('_', $gift_broadcast_base); ?>    
              <label id="<?php echo $gift_broadcast_base[0] ?>">跑道显示礼物价值基数：<input type="text" value="<?php echo $gift_broadcast_base[1] ?>" id="gift_broadcast_base" name="gift_broadcast_base" class="input-sm"></label>
               <?php $room_kick_time = explode('_', $room_kick_time); ?>      
              <label id="<?php echo $room_kick_time[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              踢出房间分钟限制：<input type="text" value="<?php echo $room_kick_time[1] ?>" id="room_kick_time" name="room_kick_time" class="input-sm"></label>
               <?php $week_gifts = explode('_', $week_gifts); ?>      
              <label id="<?php echo $week_gifts[0] ?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <font color="red">本周抢星礼物：<input type="text" value="<?php echo $week_gifts[1] ?>" id="week_gifts" name="week_gifts" class="input-sm"></font></label>
               <?php $month_gifts = explode('_', $month_gifts); ?>   
              <label id="<?php echo $month_gifts[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <font color="red">本月抢星礼物：</font><input type="text" value="<?php echo $month_gifts[1] ?>" id="month_gifts" name="month_gifts" class="input-sm"></label>
               <?php $last_week_gifts = explode('_', $last_week_gifts); ?>     
              <label id="<?php echo $last_week_gifts[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              上周抢星礼物：<input type="text" value="<?php echo $last_week_gifts[1] ?>" id="last_week_gifts" name="last_week_gifts" class="input-sm"></label>
               <?php $last_month_gifts = explode('_', $last_month_gifts); ?>     
              <label id="<?php echo $last_month_gifts[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              上月抢星礼物：<input type="text" value="<?php echo $last_month_gifts[1] ?>" id="last_month_gifts" name="last_month_gifts" class="input-sm"></label>

      </div>
      <div class="tab-pane fade" id="profile">
         
               <?php $coin_scale = explode('_', $coin_scale); ?>
              <label id="<?php echo $coin_scale[0] ?>">&nbsp;&nbsp;&nbsp;
              (RMB → 金币) 比例：<input type="text" value="<?php echo $coin_scale[1] ?>" id="coin_scale" name="coin_scale" class="input-sm"></label>
              <?php $integral_scale = explode('_', $integral_scale); ?>
              <label id="<?php echo $integral_scale[0] ?>">&nbsp;&nbsp;&nbsp;
              (RMB → 积分) 比例：<input type="text" value="<?php echo $integral_scale[1] ?>" id="integral_scale" name="integral_scale" class="input-sm"></label>
              <?php $bean_scale = explode('_', $bean_scale); ?>
              <label id="<?php echo $bean_scale[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;
              (金豆 → 豆豆) 比例：<input type="text" value="<?php echo $bean_scale[1] ?>" id="bean_scale" name="bean_scale" class="input-sm"></label>
               <?php $exchange_scale = explode('_', $exchange_scale); ?>
              <label id="<?php echo $exchange_scale[0] ?>">&nbsp;&nbsp;&nbsp;
              (豆豆 → RMB) 比例：<input type="text" value="<?php echo $exchange_scale[1] ?>" id="exchange_scale" name="exchange_scale" class="input-sm"></label>
               <?php $ip_reg_limit = explode('_', $ip_reg_limit); ?>
              <label id="<?php echo $ip_reg_limit[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              普通注册分钟限制：<input type="text" value="<?php echo $ip_reg_limit[1] ?>" id="ip_reg_limit" name="ip_reg_limit" class="input-sm"></label>
               <?php $ip_reg_limit = explode('_', $ip_reg_limit); ?>
              <label id="<?php echo $ip_reg_limit[0] ?>">&nbsp;&nbsp;&nbsp;
              注册推荐人奖励Ｕ币：<input type="text" id="ip_reg_limit" value="<?php echo $ip_reg_limit[1] ?>" name="ip_reg_limit" class="input-sm"></label>
               <?php $reco_reg_limit = explode('_', $reco_reg_limit); ?>
              <label id="<?php echo $reco_reg_limit[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              推荐注册分钟限制：<input type="text" id="reco_reg_limit" value="<?php echo $reco_reg_limit[1] ?>" name="reco_reg_limit" class="input-sm"></label>
               <?php $reco_reg_award = explode('_', $reco_reg_award); ?>
              <label id="<?php echo $reco_reg_award[0] ?>">&nbsp;&nbsp;&nbsp;
              注册推荐人奖励Ｕ币：<input type="text" id="reco_reg_award" value="<?php echo $reco_reg_award[1] ?>" name="reco_reg_award" class="input-sm"></label>
               <?php $louderspeak = explode('_', $louderspeak); ?>
              <label id="<?php echo $louderspeak[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              小喇叭Ｕ币：<input type="text" id="louderspeak" value="<?php echo $louderspeak[1] ?>" name="louderspeak" class="input-sm"></label>
               <?php $gift_car = explode('_', $gift_car); ?>
              <label id="<?php echo $gift_car[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              系统活动：<select  id="gift_car"  name="gift_car"  class="input-sm">
                     <option value="0">关闭</option>
                     <option value="1">开启</option>
                   </select>
              </label>
              <input type="hidden" id="gcar" value="<?php echo $gift_car[1] ?>">
               <?php $viruser_scale = explode('_', $viruser_scale); ?>
              <label id="<?php echo $viruser_scale[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              虚拟人/真人 比例：<input type="text" id="viruser_scale" value="<?php echo $viruser_scale[1] ?>" name="viruser_scale" class="input-sm"></label>
              
              

      </div>
      <div class="tab-pane fade" id="show">

                <?php $room_icon_size = explode('_', $room_icon_size); ?>
              <label id="<?php echo $room_icon_size[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间图标长宽：<input type="text" id="room_icon_size" value="<?php echo $room_icon_size[1] ?>" name="room_icon_size" class="input-sm"></label>
               <?php $room_images_size = explode('_', $room_images_size); ?>
              <label id="<?php echo $room_images_size[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              聊天背景长宽：<input type="text" id="room_images_size" value="<?php echo $room_images_size[1] ?>" name="room_images_size" class="input-sm"></label>
               <?php $thumb_bgcolor = explode('_', $thumb_bgcolor); ?>
              <label id="<?php echo $thumb_bgcolor[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              缩略图背景颜色：<input type="text" id="thumb_bgcolor" value="<?php echo $thumb_bgcolor[1] ?>" name="thumb_bgcolor" class="input-sm"></label>
               <?php $gift_thumb_images_size = explode('_', $gift_thumb_images_size); ?>
              <label id="<?php echo $gift_thumb_images_size[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              礼物缩略图长宽：<input type="text" id="gift_thumb_images_size" value="<?php echo $gift_thumb_images_size[1] ?>" name="gift_thumb_images_size" class="input-sm"></label>
               <?php $magic_thumb_images_size = explode('_', $magic_thumb_images_size); ?>
              <label id="<?php echo $magic_thumb_images_size[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              道具缩略图长宽：<input type="text" id="magic_thumb_images_size" value="<?php echo $magic_thumb_images_size[1] ?>" name="magic_thumb_images_size" class="input-sm"></label>


      </div>
      <div class="tab-pane fade" id="api">

                <?php $version = explode('_', $version); ?>
              <label id="<?php echo $version[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              版本号：<input type="text" id="version" value="<?php echo $version[1] ?>" name="version" class="input-sm"></label>
               <?php $soft_update = explode('_', $soft_update); ?>
              <label id="<?php echo $soft_update[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              软件更新：<input type="text" id="soft_update" value="<?php echo $soft_update[1] ?>" name="soft_update" class="input-sm"></label>
               <?php $key = explode('_', $key); ?>
              <label id="<?php echo $key[0] ?>">
              客户端通信加密串：<input type="text" id="key" value="<?php echo $key[1] ?>" name="key" class="input-sm"></label>
               <?php $center_host = explode('_', $center_host); ?>
              <label id="<?php echo $center_host[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              中心主机：<input type="text" id="center_host" value="<?php echo $center_host[1] ?>" name="center_host" class="input-sm"></label>
               <?php $web_api_url = explode('_', $web_api_url); ?>
              <label id="<?php echo $coin_scale[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              API地址：<input type="text" id="web_api_url" value="<?php echo $web_api_url[1] ?>" name="web_api_url" class="input-sm"></label>
               <?php $chat_server = explode('_', $chat_server); ?>
              <label id="<?php echo $chat_server[0] ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              聊天服务器：<input type="text" id="chat_server" value="<?php echo $chat_server[1] ?>" name="chat_server" class="input-sm"></label>

          
      </div>


  </div>

</div>

<div class="btn-toolbar">
<a   id="save" class="btn btn-primary">保存</a>
    <a id="reset" data-toggle="modal1" class="btn">重置</a>
  <div class="btn-group">
  </div>
</div>
</form>
</div>

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/systemset/syset.js" type="text/javascript"></script>
