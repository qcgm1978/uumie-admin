<div class="span10">
    <h4 class="page-title">主播申请列表</h4>
    
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
      <input type="hidden" id="url" value="<?php echo $this->createUrl("anchor/apply") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("anchor/apply") ?>">
       <tr role="row">
		   <th aria-label="真实姓名">真实姓名</th>
		   <th aria-label="手机号">手机号</th>
       <th aria-label="qq号">qq号</th>
       <th aria-label="所在地">所在地</th>
       <th aria-label="自我介绍">自我介绍</th>
       <th aria-label="特长">特长</th>
       <th aria-label="上网时间">上网时间</th>
       <th aria-label="申请时间">申请时间</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/anchor/apply.js" type="text/javascript"></script>

