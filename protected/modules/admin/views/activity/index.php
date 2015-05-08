<div class="span10">
    <h4 class="page-title">审核回复列表</h4>
  
<div class="btn-toolbar">
   <form class="form-inline">
      <label>&nbsp;&nbsp;</label>
      <label>&nbsp;&nbsp;会员名称 ：&nbsp;&nbsp;</label><input class="input-small" id="nickname" type="text">
      <label>&nbsp;&nbsp;</label>
      <label>&nbsp;&nbsp;反馈类型 ：&nbsp;&nbsp;</label><input class="input-small" id="type" type="text">

      <label>&nbsp;审核状态：&nbsp;</label>
      <select class="span2" id="audit">
       <option value="">全部</option>
        <option value="1">审核通过</option>
        <option value="2">审核未通过</option>
      </select>
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label>
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
       <label>&nbsp;&nbsp;</label>

        <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
    </form>
 <a onclick="answerlist()"  class="btn btn-info btn-sm">发布榜单</a>

</div>

<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("activity/index") ?>">
      <input type="hidden" id="updateinfo" value="<?php echo $this->createUrl("activity/recommend") ?>">
      <input type="hidden" id="salenumber" value="<?php echo $this->createUrl("activity/sales") ?>">
      <input type="hidden" id="answerlist" value="<?php echo $this->createUrl("activity/aclist") ?>">
       <tr role="row">
       <th><input type="checkbox" id="all" /></th>
       <th aria-label="会员名">会员名</th>
       <th aria-label="反馈类型">反馈类型</th>
       <th aria-label="反馈内容">反馈内容</th>
       <th aria-label="联系方式">联系方式</th>
       <th aria-label="添加时间">添加时间</th>
       <th aria-label="审核状态">审核状态</th>
       <th aria-label="操作">操作</th>
    </tr>
      </thead>
      <tbody id="content">
        
      </tbody> 
    </table>
</div>

<div class="pagination">
  
  <div >
  <select style="float:left;" class="span2" id="selaction">
      <option value="">请选择</option>
      <option value="1">审核全部通过</option>
      <option value="2">审核全部不通过</option>
  </select>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn" id="sales" style="float:left;">提交</button>
      <ul id="pagination" style="float:right;">
      </ul>
    </div>
</div>

</div>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker-bs2.css">

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker-bs3.css">

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/moment.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/activity/index.js" type="text/javascript"></script>
