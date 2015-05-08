<div class="span10">
    <h4 class="page-title">麦时记录</h4>
    <a href="<?php echo $this->createUrl("anchor/index") ?>" style="float:right;" class="btn btn-info btn-sm">主播列表</a>
<div class="btn-toolbar">
   <form class="form-inline">
      <label>号码 ：&nbsp;</label><input class="input-small" id="gid" type="text">
      <label class="input">&nbsp;房间号 ：</label><input  id="roomid" class="input-small" value="<?php echo $roomid ?>" type="text"> 
              <div class="input-prepend input-group">
              <label>起始时间：</label>
              <div class="input-prepend input-group">
                <span class="add-on input-group-addon">
                  <i class="glyphicon glyphicon-calendar fa fa-calendar">
                  </i>
                </span>
                <input type="text" style="width: 100px" name="birthday" id="starttime"
                class="form-control" value="<?php echo $starttime; ?>" />
                </div>
                  <label>结束时间：</label>
                <div class="input-prepend input-group">
                <span class="add-on input-group-addon">
                  <i class="glyphicon glyphicon-calendar fa fa-calendar">
                  </i>
                </span>
                <input type="text" style="width: 100px" name="birthday" id="endtime"
                class="form-control" value="<?php echo $endtime; ?>" />
              </div>
              </div>
      <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>

    </form>
</div>
<div class="well">
    <table class="table">
      <thead>

      <input type="hidden" id="url" value="<?php echo $this->createUrl('anchor/livelogs') ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl('anchor/livelogs',array($key=>$val)) ?>">

      <input type="hidden" id="uid" value="<?php echo $uid; ?>">
       
       <tr role="row">
		   <th aria-label="昵称">昵称</th>
       <th aria-label="在麦时长">在麦时长</th>
       <th aria-label="所在房间">所在房间</th>
       <th aria-label="上麦时间">上麦时间</th>
		   <th aria-label="下麦时间">下麦时间</th>
		</tr>
      </thead>
      <tbody id="content">
      	
      </tbody> 
    </table>
</div>

<div class="pagination">
	<div style="float:right;">
	    <ul id="pagination">
	    </ul>
    </div>
</div>

</div>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker-bs2.css">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker-bs3.css">






<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/moment.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/anchor/livelogs.js" type="text/javascript"></script>
