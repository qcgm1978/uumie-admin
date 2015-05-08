<div class="span10">
    <h4 class="page-title">主播列表</h4>
    
    <a href="<?php echo $this->createUrl("family/add") ?>" style="float:right;" class="btn btn-info btn-sm">添加家族</a>
<div class="btn-toolbar">
   <form class="form-inline">
      <label class="input">家族名称 ：&nbsp;</label><input  id="fname" class="input-sm" type="text">
      <label>&nbsp;&nbsp;家族长号 ：&nbsp;&nbsp;</label><input class="input-sm" id="flead" type="text">
      <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="url" value="<?php echo $this->createUrl("family/index") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("family/index") ?>">
      <input type="hidden" id="del" value="<?php echo $this->createUrl("family/delete") ?>">
      <input type="hidden" id="updateinfo" value="<?php echo $this->createUrl("family/recommend") ?>">
       <tr role="row">
		   <th aria-label="家族名">家族名</th>
		   <th aria-label="创建时间">创建时间</th>
       <th aria-label="最后修改时间">最后修改时间</th>
       <th aria-label="家族族长">家族族长</th>
       <th aria-label="推荐">推荐</th>
       <th aria-label="家族徽章文字">家族徽章文字</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/family/index.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
