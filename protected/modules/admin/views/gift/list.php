<div class="span10">
    <h4 class="page-title">礼物列表</h4>
   
    <a href="<?php echo $this->createUrl("gift/add") ?>" style="float:right;" class="btn btn-info btn-sm">添加礼物</a>
<div class="btn-toolbar">
   <form class="form-inline">
       <label>&nbsp;&nbsp;</label>
       <select class="span2" id="catpye">
       <option value="">全部分类</option>
         <?php  foreach($info as $k=>$v): ?>
        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
        <?php endforeach ?>
      </select><label>&nbsp;&nbsp;</label>
      <select class="span2" id="giftype">
       <option value="">全部类型</option>
        <option value="0" selected = "selected">全部显示</option>
        <option value="1">逐行刷屏</option>
      </select>
      <label>&nbsp;&nbsp;礼物名称 ：&nbsp;&nbsp;</label><input class="input-sm" id="giftname" type="text">
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("gift/list") ?>">
      <input type="hidden" id="updateinfo" value="<?php echo $this->createUrl("gift/updateinfo") ?>">
      <input type="hidden" id="salenumber" value="<?php echo $this->createUrl("gift/sales") ?>">
      <input type="hidden" id="shelves" value="<?php echo $this->createUrl("gift/shelves") ?>">
       <tr role="row">
       <th aria-label="礼物名称">礼物名称</th>
       <th aria-label="礼物分类">礼物分类</th>
       <th aria-label="显示效果">显示效果</th>
       <th aria-label="价格">价格</th>
       <th aria-label="单位">单位</th>
       <th aria-label="隐藏">隐藏</th>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/gift/list.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
