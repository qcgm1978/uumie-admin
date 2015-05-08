<div class="span10">
    <h4 class="page-title">服务器列表</h4>
   
    <a href="<?php echo $this->createUrl("systemset/add") ?>" style="float:right;" class="btn btn-info btn-sm">添加服务器</a>
<div class="btn-toolbar">
   <form class="form-inline">
       <label>&nbsp;&nbsp;</label>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("systemset/server") ?>">
      <input type="hidden" id="updateinfo" value="<?php echo $this->createUrl("systemset/del") ?>">
      <tr role="row">
       <th aria-label="集群编号">集群编号</th>
       <th aria-label="集群名称">集群名称</th>
       <th aria-label="网络">网络</th>
       <th aria-label="主机地址">主机地址</th>
       <th aria-label="端口">端口</th>
       <th aria-label="房间数">房间数</th>
       <th aria-label="操作">操作</th>
    </tr>
      </thead>
      <tbody id="content">
        
      </tbody> 
    </table>
</div>

<div class="pagination">
  
  <div>
      <ul id="pagination" style="float:right;">
      </ul>
    </div>
</div>

</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/systemset/server.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
