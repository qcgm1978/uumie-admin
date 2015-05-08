<div class="span10">
    <h4 class="page-title">虚拟人库</h4>
    
    <a href="<?php echo $this->createUrl("user/add") ?>" style="float:right;" class="btn btn-info btn-sm">添加虚拟人</a>
<div class="btn-toolbar">
   <form class="form-inline">
      <label class="input">昵称 ：&nbsp;</label><input  id="username" class="input-sm" type="text"> <label>&nbsp;&nbsp;号码 ：&nbsp;&nbsp;</label><input class="input-sm" id="uid" type="text">
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
        
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="url" value="<?php echo $this->createUrl("user/virtuallist") ?>">
      <input type="hidden" id="editVirtual" value="<?php echo $this->createUrl("user/editvirtual") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("user/virtual") ?>">
      <input type="hidden" id="delvirtual" value="<?php echo $this->createUrl("user/delvirtual") ?>">
       <tr role="row">
		   <th aria-label="号码">号码</th>
		   <th aria-label="昵称">昵称</th>
		   <th aria-label="注册时间">注册时间</th>
		   <th aria-label="最后登陆">最后登陆</th>
		   <th aria-label="最后登录IP">最后登录IP</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/user/virtual.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
