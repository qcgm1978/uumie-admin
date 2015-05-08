<div class="span10">
    <h4 class="page-title">房间列表</h4>
    
    <a href="<?php echo $this->createUrl("room/addroom") ?>" style="float:right;" class="btn btn-info btn-sm">添加房间</a>
<div class="btn-toolbar">
   <form class="form-inline">
       <select class="span2" id="goodnum">
       <option value="0">全部分类</option>
         <?php foreach($info as $v): ?>
        <option value="<?php echo $v['cat_id']; ?>"><?php echo $v['cat_name']; ?></option>
        <?php endforeach ?>
      </select><label>&nbsp;&nbsp;</label>
      <select class="span2" id="saleway">
       <option value="">全部</option>
        <option value="1">锁定</option>
        <option value="2">隐藏</option>
        <option value="3">推荐</option>
      </select><label>&nbsp;&nbsp;</label>
      <select class="span2" id="home">
       <option value="">全部</option>
        <option value="1">家族房</option>
        <option value="2">直播房</option>
      </select>
      <label>&nbsp;&nbsp;号码 ：&nbsp;&nbsp;</label><input class="input-sm" id="gid" type="text">
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>
    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="checklen" value="<?php echo $this->createUrl("user/CheckNameLen") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("room/list") ?>">
      <input type="hidden" id="updateinfo" value="<?php echo $this->createUrl("room/updateinfo") ?>">
      <input type="hidden" id="salenumber" value="<?php echo $this->createUrl("room/sales") ?>">
      <input type="hidden" id="shelves" value="<?php echo $this->createUrl("room/shelves") ?>">
       <tr role="row">
       <th><input type="checkbox" id="all" /></th>
       <th aria-label="编号">编号</th>
       <th aria-label="名称">名称</th>
       <th aria-label="直播状态">直播状态</th>
       <th aria-label="码流">码流</th>
       <th aria-label="容纳">容纳</th>
       <th aria-label="推荐">推荐</th>
       <th aria-label="关闭">关闭</th>
       <th aria-label="隐藏">隐藏</th>
       <th aria-label="排序">排序</th>
       <th aria-label="机房">机房</th>
       <th aria-label="房主号码">房主号码</th>
       <th aria-label="操作">操作</th>
    </tr>
      </thead>
      <tbody id="content">
        
      </tbody> 
    </table>
</div>

<div class="pagination">
  
  <div >
  <select style="float:left;" class="span2" id="selAction" onchange="selaction(this.value)">
      <option value="">请选择</option>
      <option value="1">删除</option>
      <option value="2">推荐</option>
      <option value="3">解除推荐</option>
      <option value="4">关闭</option>
      <option value="5">解除关闭</option>
      <option value="6">隐藏</option>
      <option value="7">解除隐藏</option>
      <option value="8">转移到分类</option>
  </select>&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn" id="tsubmit" style="float:left;">提交</button>
      <ul id="pagination" style="float:right;">
      </ul>
    </div>
</div>

</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/room/list.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/room/click.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
