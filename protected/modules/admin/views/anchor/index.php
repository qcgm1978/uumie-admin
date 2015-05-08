<div class="span10">
    <h4 class="page-title">主播列表</h4>
    
    <a href="<?php echo $this->createUrl("anchor/livelogs",array('name'=>'uid','val'=>0)) ?>" style="float:right;" class="btn btn-info btn-sm">在麦记录</a><span style="float:right;">&nbsp;</span>
    <a href="<?php echo $this->createUrl("anchor/add") ?>" style="float:right;" class="btn btn-info btn-sm">添加主播</a>
<div class="btn-toolbar">
   <form class="form-inline">
      <label class="input">昵称 ：&nbsp;</label><input  id="username" class="input-sm" type="text"> <label>&nbsp;&nbsp;号码 ：&nbsp;&nbsp;</label><input class="input-sm" id="gid" type="text">
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
       <label >&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->createUrl("anchor/export") ?>" class="btn" >导出全部</a></label>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="url" value="<?php echo $this->createUrl("anchor/index") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("anchor/index") ?>">
      <input type="hidden" id="del" value="<?php echo $this->createUrl("anchor/delete") ?>">
       <tr role="row">
		   <th aria-label="号码">号码</th>
		   <th aria-label="昵称">昵称</th>
       <th aria-label="本月麦时">本月麦时</th>
       <th aria-label="U币">U币</th>
       <th aria-label="U豆">U豆</th>
       <th aria-label="可兑现(RMB)">可兑现(RMB)</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/anchor/index.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
