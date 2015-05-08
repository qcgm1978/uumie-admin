<div class="span10">
<h4 class="page-title">用户充值统计列表</h4>
<!-- <a href="" onclick="back()" style="float:right;" class="btn btn-info btn-sm">返回</a><span style="float:right;">&nbsp;</span>    
 --><div class="btn-toolbar">
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
      <input type="hidden" id="url" value="<?php echo $this->createUrl("statistics/pay") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("statistics/pay") ?>">
       <tr role="row">
       <th aria-label="时间">时间</th>
       <th aria-label="10元以下人数">10元以下人数</th>
       <th aria-label="10-30元人数">10-30元人数</th>
       <th aria-label="30-50元人数">30-50元人数</th>
       <th aria-label="50-100元人数">50-100元人数</th>
       <th aria-label="100元以上人数">100元以上人数</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/statistics/pay.js" type="text/javascript"></script>

