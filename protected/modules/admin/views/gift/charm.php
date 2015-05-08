<div class="span10">
    <h4 class="page-title">明星等级</h4>
    
<div class="btn-toolbar">
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="url" value="<?php echo $this->createUrl("gift/charm") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("gift/charm") ?>">
      <input type="hidden" id="updateinfo" value="<?php echo $this->createUrl("gift/edcharm") ?>">
      <input type="hidden" id="delwatchman" value="<?php echo $this->createUrl("gift/delwatchman") ?>">
       <tr role="row">
		   <th aria-label="头衔图片">头衔图片</th>
		   <th aria-label="头衔名称">头衔名称</th>
       <th aria-label="升级点数">升级点数</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/gift/charm.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
