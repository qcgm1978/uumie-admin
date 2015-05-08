<div class="span10">
    <h4 class="page-title">每日统计</h4>
    
<div class="btn-toolbar">
   <form class="form-inline">
      
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
      <input type="hidden" id="url" value="<?php echo $this->createUrl("statistics/daily") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("statistics/daily") ?>">
       <tr role="row">
		   <th aria-label="时间">时间</th>
		   <th aria-label="消费总额">消费总额</th>
       <th aria-label="充值总额">充值总额</th>
       <th aria-label="充值个数">充值个数</th>
       <th aria-label="vip数量">vip数量</th>
       <th aria-label="爵位数量">爵位数量</th>
       <th aria-label="新增主播个数">新增主播个数</th>
       <th aria-label="直播个数">直播个数</th>
       <th aria-label="兑点个数">兑点个数</th>
       <th aria-label="兑点总额">爵位数量</th>
       <th aria-label="新增注册">新增注册</th>
       <th aria-label="登录个数">登录个数</th>
       <th aria-label="购买vip">购买vip</th>
       <th aria-label="礼物总数">礼物总数</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/statistics/daily.js" type="text/javascript"></script>

