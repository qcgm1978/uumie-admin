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
      </select>
     <label>&nbsp;&nbsp; &nbsp;&nbsp;</label>
     <select class="span2" id="saleway">
       <option value="0">获取方式</option>
        <option value="1">金币</option>
        <option value="2">积分</option>
        <option value="3">赠送</option>
        <option value="4">分配</option>
      </select>
      
      <label>&nbsp;&nbsp;&nbsp;&nbsp;号码 ：&nbsp;&nbsp;<input class="input-sm" id="gid" type="text">&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <label class="checkbox">
      <input type="checkbox" id="allgid"> 此人全部
    </label><label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("numbers/numsold") ?>">
       <tr role="row">
       <th aria-label="号码">号码</th>
       <th aria-label="类型">类型</th>
       <th aria-label="购买">购买</th>
       <th aria-label="价格">价格</th>
       <th aria-label="昵称">昵称</th>
       <th aria-label="时间">时间</th>
    </tr>
      </thead>
      <tbody id="content">
        
      </tbody> 
    </table>
</div>

<div class="pagination">
  
  <div >
      <ul id="pagination" style="float:right;">
      </ul>
    </div>
</div>

</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/number/numsold.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
