<div class="span10">
    <h4 class="page-title">爵位会员</h4>
    <a href="<?php echo $this->createUrl("finance/addtitle") ?>" style="float:right;" class="btn btn-info btn-sm">销售爵位</a><span style="float:right;">&nbsp;</span>
<div class="btn-toolbar">
   <form class="form-inline">
              
      
        <label >&nbsp;&nbsp;用户号码：&nbsp;&nbsp;</label><input type="text" id="gid" class="input-sm"> 
        <label >&nbsp;&nbsp;</label>
      <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>

    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="delUrl" value="<?php echo $this->createUrl("finance/delmem") ?>">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/titlemem") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("finance/titlemem") ?>">
      <input type="hidden" id="reconid" value="<?php echo $reconid; ?>">
      <input type="hidden" id="uid" value="<?php echo $uid; ?>">
       <tr role="row">
		   <th>用户号码</th>
		   <th>用户昵称</th>
       <th>来源</th>
       <th>爵位名称</th>
       <th>开通方式</th>
       <th>开通时间</th>
       <th>到期时间</th>
       <th>状态</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/titlemem.js" type="text/javascript"></script>

