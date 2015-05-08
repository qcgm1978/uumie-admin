<div class="span10">
    <h4 class="page-title">家族主播信息</h4>
    
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
      <input type="hidden" id="url" value="<?php echo $this->createUrl("family/anchor") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("family/anchor",array('fid'=>$fid,'isanchor'=>$isanchor)) ?>">
      <input type="hidden" id="fid" value="<?php echo $fid ?>">
      <input type="hidden" id="isanchor" value="<?php echo $isanchor ?>">
       <tr role="row">
		   <th aria-label="家族名称">家族名称</th>
		   <th aria-label="号码">号码</th>
       <th aria-label="用户名">用户名</th>
       <th aria-label="当月收入U币">当月收入U币</th>
       <th aria-label="当月直播时长">当月直播时长</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/family/anchor.js" type="text/javascript"></script>

