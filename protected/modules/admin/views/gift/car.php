<div class="span10">
    <h4 class="page-title">座驾管理</h4>
   
    <a href="<?php echo $this->createUrl("gift/addcar") ?>" style="float:right;" class="btn btn-info btn-sm">添加座驾</a>
<div class="btn-toolbar">
   <form class="form-inline">
       <label>&nbsp;&nbsp;</label>
       
    
      <label>&nbsp;&nbsp;座驾名称 ：&nbsp;&nbsp;</label><input class="input-sm" id="carname" type="text">
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("gift/car") ?>">
      <input type="hidden" id="updateinfo" value="<?php echo $this->createUrl("gift/carinfo") ?>">
      <tr role="row">
       <th aria-label="座驾名称">座驾名称</th>
       <th aria-label="价格">价格</th>
       <th aria-label="有效期(天)">有效期(天)</th>
       <th aria-label="隐藏">隐藏</th>
       <th aria-label="活动座驾">活动座驾</th>
       <th aria-label="排序">排序</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/gift/car.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
