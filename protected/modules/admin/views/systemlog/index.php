<div class="span10">
    <h4 class="page-title">管理员日志</h4>
    
<div class="btn-toolbar">
   <form class="form-inline">
      
      <label>&nbsp;&nbsp;号码 ：&nbsp;&nbsp;</label>
      <input class="input-sm" id="gid" type="text">
              <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> 
      <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>

      <label >&nbsp;&nbsp;清除日志：&nbsp;</label> 
      <select class="span2" id="logdate">

          <option value=''>选择清除的日期</option>
          <option value='1'>一个周前</option>
          <option value='2'>一个月前</option>
          <option value='3'>三个月前</option>
          <option value='4'>六个月前</option>
          <option value='5'>一年以前</option>

      </select>
          
         <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> 
      <button id="clear" class="btn" type="button"></i> 清除</button>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="url" value="<?php echo $this->createUrl("systemlog/index") ?>">
      <input type="hidden" id="uid" value="<?php echo $uid ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("systemlog/index") ?>">
      <input type="hidden" id="delog" value="<?php echo $this->createUrl("systemlog/del") ?>">

      <tr role="row">
       <th><input type="checkbox" id="all" /></th>
       <th aria-label="编号">编号</th>
       <th aria-label="操作者">操作者</th>
       <th aria-label="操作日期">操作日期</th>
       <th aria-label="IP地址">IP地址</th>
       <th aria-label="操作记录">操作记录</th>
    </tr>
      </thead>
      <tbody id="content">
        
      </tbody> 
    </table>
</div>

<div class="pagination">
  
  <div >
    <button type="button" class="btn" id="delted" style="float:left;">删除日志</button>
      <ul id="pagination" style="float:right;">
      </ul>
    </div>
</div>

</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/systemlog/index.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
