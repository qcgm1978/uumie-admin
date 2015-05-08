<div class="span10">
    <h4 class="page-title">在售号码</h4>
    
    <a href="<?php echo $this->createUrl("numbers/index") ?>" style="float:right;" class="btn btn-info btn-sm">可用号库</a>
<div class="btn-toolbar">
   <form class="form-inline">
       <select class="span2" id="goodnum">
       <option value="0">靓号类型</option>
        <option value="4">四位靓号</option>
        <option value="5">五位靓号</option>
        <option value="6">六位靓号</option>
        <option value="7">七位靓号</option>
      </select><label>&nbsp;&nbsp;</label>
      <select class="span2" id="saleway">
       <option value="0">出售方式</option>
        <option value="1">金币</option>
        <option value="2">积分</option>
      </select>
      <label>&nbsp;&nbsp;号码 ：&nbsp;&nbsp;</label><input class="input-sm" id="gid" type="text">
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("numbers/saleinnum") ?>">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("numbers/saleinnum") ?>">
      <input type="hidden" id="editVirtual" value="<?php echo $this->createUrl("numbers/editvirtual") ?>">
      <input type="hidden" id="salenumber" value="<?php echo $this->createUrl("numbers/sales") ?>">
      <input type="hidden" id="shelves" value="<?php echo $this->createUrl("numbers/shelves") ?>">
       <tr role="row">
       <th><input type="checkbox" id="all" /></th>
       <th aria-label="号码">号码</th>
       <th aria-label="类型">类型</th>
       <th aria-label="出售">出售</th>
       <th aria-label="价格">价格</th>
       <th aria-label="描述">描述</th>
       <th aria-label="操作">操作</th>
    </tr>
      </thead>
      <tbody id="content">
        
      </tbody> 
    </table>
</div>

<div class="pagination">
  
  <div >
    <button type="button" class="btn" id="sales" style="float:left;">批量下架</button>
      <ul id="pagination" style="float:right;">
      </ul>
    </div>
</div>

</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/number/saleinnum.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
