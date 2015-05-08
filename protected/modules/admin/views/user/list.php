<div class="span10">
<h4 class="page-title">会员列表</h4>
<a href="<?php echo $this->createUrl("numbers/index") ?>" style="float:right;" class="btn btn-info btn-sm">添加会员</a>
<div class="btn-toolbar">
    <form class="form-inline">
     <label>&nbsp;&nbsp;</label>
      <label>&nbsp;&nbsp;帐号 ：&nbsp;&nbsp;</label><input class="input-small" id="username" type="text">
     <label>&nbsp;&nbsp;</label>
      <label>&nbsp;&nbsp;昵称 ：&nbsp;&nbsp;</label><input class="input-small" id="nickname" type="text">
      <label >&nbsp;&nbsp;&nbsp;&nbsp;</label>
          <div class="input-prepend input-group">
            <label>登录起始时间：</label>
            <div class="input-prepend input-group">
              <span class="add-on input-group-addon">
                <i class="glyphicon glyphicon-calendar fa fa-calendar">
                </i>
              </span>
              <input  type="text" style="width: 100px" name="birthday" id="starttime"
              class="form-control" value="" />
              </div>
              <label>&nbsp;&nbsp;</label>
                <label>登录结束时间：</label>
              <div class="input-prepend input-group">
              <span class="add-on input-group-addon">
                <i class="glyphicon glyphicon-calendar fa fa-calendar">
                </i>
              </span>
              <input type="text" style="width: 100px" name="birthday" id="endtime"
              class="form-control" />
            </div>
            </div>
      <label>&nbsp;&nbsp;</label>
      <label>&nbsp;&nbsp;号码 ：&nbsp;&nbsp;</label><input class="input-small" id="gid" type="text">
      <label>&nbsp;&nbsp;</label>
      <label>&nbsp;&nbsp;来源 ：&nbsp;&nbsp;</label><input class="input-small" id="comefrom" type="text">
      <label >&nbsp;&nbsp;&nbsp;&nbsp;</label>
          <div class="input-prepend input-group">
            <label>注册起始时间：</label>
            <div class="input-prepend input-group">
              <span class="add-on input-group-addon">
                <i class="glyphicon glyphicon-calendar fa fa-calendar">
                </i>
              </span>
              <input type="text" style="width: 100px" name="birthday" id="rstarttime"
              class="form-control" />
              </div>
              <label>&nbsp;&nbsp;</label>
                <label>注册结束时间：</label>
              <div class="input-prepend input-group">
              <span class="add-on input-group-addon">
                <i class="glyphicon glyphicon-calendar fa fa-calendar">
                </i>
              </span>
              <input type="text" style="width: 100px" name="birthday" id="rendtime"
              class="form-control" />
            </div>
            </div>
       <label>&nbsp;&nbsp;</label>
       <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>

    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="url" value="<?php echo $this->createUrl("user/ajax") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("user/list") ?>">
      <input type="hidden" id="addvirtual" value="<?php echo $this->createUrl("user/addvirtual") ?>">
       <tr role="row">
		   <th aria-label="UID">UID</th>
		   <th aria-label="号码">号码</th>
		   <th aria-label="帐号">帐号</th>
		   <th aria-label="昵称">昵称</th>
		   <th aria-label="注册时间">注册时间</th>
		   <th aria-label="最后登陆">最后登陆</th>
		   <th aria-label="最后登录IP">最后登录IP</th>
		   <th aria-label="最后连接服务器">最后连接服务器</th>
		   <th aria-label="来源">来源</th>
		   <th aria-label="推荐人数">推荐人数</th>
		   <th aria-label="操作">操作</th>
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

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/user/list.js" type="text/javascript"></script>

