<div class="span10">
    <h4 class="page-title">可用号库</h4>
    
    <a href="<?php echo $this->createUrl("numbers/saleinnum") ?>" style="float:right;" class="btn btn-info btn-sm">在售号码</a>
<div class="btn-toolbar">
   <form class="form-inline">
       <select class="span2" id="goodnum">
        <option value="4">四位靓号</option>
        <option value="5">五位靓号</option>
        <option value="6">六位靓号</option>
        <option value="7">七位靓号</option>
      </select>
      <label>&nbsp;&nbsp;号码 ：&nbsp;&nbsp;</label><input class="input-sm" id="gid" type="text"><label class="input">&nbsp;&nbsp;号段 ：&nbsp;</label><input  id="mingid" class="input-small" type="text"><label>&nbsp;&nbsp;—&nbsp;&nbsp;</label><input  id="maxgid" class="input-small" type="text">
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="url" value="<?php echo $this->createUrl("numbers/numberlist") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("numbers/index") ?>">
      <input type="hidden" id="salenumber" value="<?php echo $this->createUrl("numbers/sales") ?>">
       <tr role="row">
       <th><input type="checkbox" id="all" /></th>
       <th aria-label="号码">号码</th>
       <th aria-label="昵称">状态</th>
       <th aria-label="操作">操作</th>
    </tr>
      </thead>
      <tbody id="content">
        
      </tbody> 
    </table>
</div>

<div class="pagination">
  
  <div >
    <button type="button" class="btn" id="sales" style="float:left;">批量出售</button>
      <ul id="pagination" style="float:right;">
      </ul>
    </div>
</div>

</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/number/index.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
