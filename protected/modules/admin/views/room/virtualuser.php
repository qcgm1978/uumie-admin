<div class="span10">
            <h4 class="page-title">房间虚拟人</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("room/addvirtual") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
    <input class="input-sm" id="roomid" value="<?php echo $roomid ?>" type="hidden">
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;房间名称：
        <span id="roomname" ><?php echo $roomname ?></span>
       
        </label>
        <label></label>
         <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>虚拟会员：</span><input class="input-sm" id="virtualuser" value="0" type="text">
          </label>
           <label style="<?php if ($virtual==1) { echo 'display:none';}?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="<?php if ($virtual==1) { echo 'display:none';}?>">虚拟游客：</span><input class="input-sm" style="<?php if ($virtual==1) { echo 'display:none';}?>" id="virtualguest" value="<?php echo $virtual;?>" type="text">
          </label>
         
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;离开时间：<select class="span3" id="time">
          <option value="0">不选择离开时间使用默认60秒</option>
          <option value="1">10分钟 — 20分钟 后陆续离开</option>
          <option value="2">20分钟 — 40分钟 后陆续离开</option>
          <option value="3">30分钟 — 60分钟 后陆续离开</option>,
          <option value="4">40分钟 — 80分钟 后陆续离开</option>
        </select>
               
        
        
          
        
      </div>
  </div>

<?php $form = $this->endWidget(); ?>
</div>

<div class="btn-toolbar">
    <a   id="save" class="btn btn-primary">保存</a>
    <a id="reset" data-toggle="modal1" class="btn">重置</a>
  <div class="btn-group">
  </div>
</div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/room/virtualuser.js" type="text/javascript"></script>
