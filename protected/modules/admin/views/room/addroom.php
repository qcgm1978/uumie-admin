<div class="span10">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/uploadify/uploadify.css">
<h4 class="page-title">添加房间</h4>
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">基本信息</a></li>
      <li><a href="#property" data-toggle="tab">房间属性</a></li>
      <li ><a href="#competence" data-toggle="tab">权限设置</a></li>
    </ul>
    <input type="hidden" id="url" value="<?php echo $this->createUrl("room/AddRoom") ?>">
    <input type="hidden" id="getcat" value="<?php echo $this->createUrl("room/getcat") ?>">
    <input type="hidden" id="roomid" value="<?php echo $roomid ?>">
    <input type="hidden" id="roomnameexists" value="<?php echo $this->createUrl("room/RoomNameExists") ?>">
 <form>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间名称：<input type="text" id="room_name" value="<?php echo $roomname; ?>" name="room_name"  class="input-sm" onblur="verify()">
              <span style="color:#FF0000">*</span>
              <span id="nameNull" class="alert alert-warning"></span>
              </label>
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间分类：
                  <select id="room_cat"  name="room_cat" class="input-sm">
                    <option value="">选择分类</option>
                   <?php foreach($info as $v): ?>
                    <option value="<?php echo $v['cat_id']; ?>"><?php echo $v['cat_name']; ?></option>
                   <?php endforeach ?>
                   </select>
              <span style="color:#FF0000">*</span>
              <span id="catNull" class="alert alert-warning"></span>
              <input type="hidden" id="catid" value="<?php echo $catid ?>">     
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              扩展分类：<input type="button" onclick="addothercat()"  value="添加" class="btn btn-primary">
              <label></label>
              <div id="content">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </div>

              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              所在服务器：
                  <select id="room_server"  name="room_server" class="input-sm">
                   <option value="">选择服务器</option>
                   <?php foreach($serverList as $v): ?>
                    <option value="<?php echo $v['id']; ?>"><?php echo htmlspecialchars($v['name'] . ' (已' . $v['rooms'] . '房)', ENT_QUOTES) ; ?></option>
                   <?php endforeach ?>
                   </select>
                <span style="color:#FF0000">*</span>
                <span id="serverNull" class="alert alert-warning"></span>
                <input type="hidden" id="serverid" value="<?php echo $serverid ?>">     
              </label>
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              视频流量：
                  <select id="bitrate"  name="bitrate" class="input-sm">
                    <option value="75">75 bit</option>
                    <option value="100">100 bit</option>
                    <option value="150">150 bit</option>
                    <option value="200">200 bit</option>
                    <option value="250">250 bit</option>
                    <option value="300">300 bit</option>
                    <option value="350">350 bit</option>
                    <option value="400">400 bit</option>
                    <option value="450">450 bit</option>
                    <option value="500">500 bit</option>
                  </select>
                  <input type="hidden" id="bid" value="<?php echo $bitrate ?>">
              </label>
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              最大人数：<input type="text" value="<?php echo $maxuser ?>" id="max_user" name="max_user" class="input-sm" onblur="verify()">
              <span id="maxNull" class="alert alert-warning"></span>  </label>
               <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间类型：
                  <select id="room_type"  name="room_type" class="input-sm">
                    <option value="2">直播房-单视频</option>
                  
                   </select>
              </label>
               <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间代理：
                  <select id="agency_uid"  name="agency_uid" class="input-sm">
                    <option value="0">不选代理为官方充值通道</option>
                    <?php foreach($agencyList as $v): ?>
                    <option value="<?php echo $v['uid']; ?>"><?php echo htmlspecialchars($row['nick'] . ' (' . $row['gid'] . ')', ENT_QUOTES); ?></option>
                   <?php endforeach ?>
                   </select>
                   <input type="hidden" id="agencyuid" value="<?php echo $agencyuid ?>">
              </label> 
      </div>
      <div class="tab-pane fade" id="property">
         
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间密码：<input type="text" id="room_password" value="<?php echo $password; ?>" name="room_password" class="input-sm"></label>

               <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间欢迎词：<textarea class="span4" id="room_welcome" name="room_welcome"><?php echo $welcome; ?></textarea></label>
             <label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              麦序时长：<input type="text" class="input-small" value="<?php echo $video1; ?>" id="room_video1" name="room_video1">&nbsp;&nbsp;
                        <input type="text" class="input-small" value="<?php echo $video2; ?>" id="room_video2" name="room_video2">&nbsp;&nbsp;
                        <input type="text" class="input-small" value="<?php echo $video3; ?>" id="room_video3" name="room_video3">
             <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房间图标：<a id="upload"></a>
        <span style="color:#FF0000">*</span></label>
        <span id="iconNull" class="alert alert-warning"></span>
              <input type="hidden" id="room_icon" value="<?php echo $icon ?>" name="room_icon" class="input-sm">
            </div>
        <div class="tab-pane fade" id="competence">
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              房主(登陆账号)：
                <input type="text" id="room_owner" value="<?php echo $roomowner ?>" name="room_owner" class="input-sm">
              </label>
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              副房主： <select id="roomlimit_b"  name="roomlimit_b" class="span4" multiple="multiple">
                  <?php foreach($roomlimitb as $v): ?>
                    <option value="8"><?php echo htmlspecialchars($row['nick'] . ' (' . $row['gid'] . ')', ENT_QUOTES); ?></option>
                   <?php endforeach ?>
                  </select>
                  </label>
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              管理员：<select id="roomlimit_c"  name="roomlimit_c" class="span4" multiple="multiple">
                  <?php foreach($roomlimitc as $v): ?>
                    <option value="8"><?php if ($v['nickname']) {echo $v['nickname'];}else{ echo $v['username'];}  echo '(';if($v['gid']){echo $v['gid'];}else{ echo $v['uid'];} echo ')'; ?></option>
                   <?php endforeach ?>
                  </select></label>
        </div>
  </div>
</div>
<div class="btn-toolbar">
    <a id="save" class="btn btn-primary">保存</a>
    <a id="reset" data-toggle="modal1" class="btn">重置</a>
</div>
</form>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/room/addroom.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
 　　   $('#upload').uploadify({
            auto: true,
            //fileObjName: 'upfile',
       　　 swf      :'/assets/uploadify/uploadify.swf',
            method: 'POST',
     　　　 uploader :'<?php echo $this->createUrl('gift/UploadImg')?>',
            multi: false,
            // buttonText: '浏览',
            'buttonText': '本地上传', //设置按钮文本
            fileTypeDesc: '请选择文件',
            fileTypeExts: '*.jpg; *.jpeg; *.png; *.gif; *.bmp; *.JPG; *.JPEG; *.PNG; *.GIF; *.SWF',
            sizeLimit: 204800,
            formData: {},
        　　 // Put your options here
            onUploadSuccess: function (file, data, response) {
                console.log(data);
                obj = jQuery.parseJSON(data);
                console.log(obj);
                    if (obj.images) {
                        $("#img").val(obj.images);
                        $("#thumb").val(obj.thumb);
                        $("#images").show().html("上传的图片成功");
                    }else if(obj.flash){
                         $("#fsh").show().html("上传的flash成功")
                        $("#flash").val(obj.flash);
                    }             

                }
    　　　});
　　　});
　　
</script>