<div class="span10">
    <h4 class="page-title">会员座驾列表</h4>
    <a href="<?php echo $this->createUrl("finance/caruserea") ?>" style="float:right;" class="btn btn-info btn-sm">会员添加座驾</a><span style="float:right;">&nbsp;</span>
<div class="btn-toolbar">
   <form class="form-inline">
              
      
        <label >&nbsp;&nbsp;座驾名称：&nbsp;&nbsp;</label><input type="text" id="carname" class="input-sm"> 
        <label >&nbsp;&nbsp;</label>
        <label >&nbsp;&nbsp;会员昵称：&nbsp;&nbsp;</label><input type="text" id="username" class="input-sm"> 
        <label >&nbsp;&nbsp;</label>

      <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>

    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="delUrl" value="<?php echo $this->createUrl("finance/delid") ?>">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/caruser") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("finance/caruser") ?>">
      <input type="hidden" id="updatetype" value="<?php echo $this->createUrl("finance/updatetype") ?>">
       <tr role="row">
		   <th>座驾名称</th>
		   <th>会员昵称</th>
       <th>来源</th>
       <th>购买时间</th>
       <th>有效截止日期</th>
       <th>是否过期</th>
       <th>是否使用</th>
       <th>操作</th>
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

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/caruser.js" type="text/javascript"></script>

