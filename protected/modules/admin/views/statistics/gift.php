<div class="span10">
    <h4 class="page-title">充值记录</h4>
    
<div class="btn-toolbar">
   <form class="form-inline">
         <label>获得方式：</label><select class="span2" id="getype">
        <option value="">全部</option>
        <option value="1">黄袋</option>
        <option value="2">蓝袋</option>
        <option value="3">紫袋</option>
        
        </select>      
        <label >&nbsp;&nbsp;赠送者号码：&nbsp;&nbsp;</label><input type="text" value="<?php echo $presenter ?>" id="presenter" class="input-small"> 
        <label >&nbsp;&nbsp;</label>
         <label >&nbsp;&nbsp;接受者号码：&nbsp;&nbsp;</label><input type="text" value="<?php echo $recipient ?>" id="recipient" class="input-small"> 
        <label >&nbsp;&nbsp;</label>
        <label >&nbsp;&nbsp;房间号码：&nbsp;&nbsp;</label><input type="text" value="<?php echo $roomid ?>" id="roomid" class="input-small"> 
        <label >&nbsp;&nbsp;</label>
        <label >&nbsp;&nbsp;家族名称&nbsp;&nbsp;</label><input type="text" id="familyname" class="input-small"> 
        <label >&nbsp;&nbsp;</label>
        <label >&nbsp;&nbsp;礼物名称&nbsp;&nbsp;</label><input type="text" value="<?php echo $giftname ?>" id="giftname" class="input-small"> 
        <label >&nbsp;&nbsp;</label>
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
          <label>&nbsp;&nbsp;</label>
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
      <input type="hidden" id="url" value="<?php echo $this->createUrl("statistics/gift") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("statistics/gift",array($key=>$val)) ?>">
      <input type="hidden" id="uid" value="<?php echo "fff"; ?>">
       <tr role="row">
       <th aria-label="礼物">礼物</th>
       <th aria-label="赠送者">赠送者</th>
       <th aria-label="接受者">接受者</th>
       <th aria-label="数量(个)">数量(个)</th>
       <th aria-label="价值()币">价值()币</th>
       <th aria-label="房间">房间</th>
       <th aria-label="赠送时间">赠送时间</th>
    </tr>
      </thead>
      <tbody id="content">
        
      </tbody>
        
    </table>
</div>

<div class="pagination">
  <div style="float:left;">
    <ul>
      <li class="active"><a>数量：<span id="amountcount"></span>个，总价值：<span id="totalamount"></span>U币</a></li>
    </ul>
   
  </div>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/statistics/gift.js" type="text/javascript"></script>

