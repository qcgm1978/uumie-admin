<div class="span10">
<h4 class="page-title">家族成员列表</h4>
<a href="<?php echo $this->createUrl("family/adduser",array('fid'=>$fid)) ?>" style="float:right;" class="btn btn-info btn-sm">添加家族成员</a>
<div class="btn-toolbar">
   <form class="form-inline">
      <label >&nbsp;&nbsp;&nbsp;&nbsp;</label>
       <label class="input">用户名 ：&nbsp;</label><input  id="uname" class="input-sm" type="text">
        <label>&nbsp;&nbsp;&nbsp;是否主播：&nbsp;&nbsp;</label><select class="span2" id="isanchor">
        <option value="">全部</option>
        <option value="1">非</option>
        <option value="2">是</option>
        
        </select>
      <label>&nbsp;&nbsp;</label>

       <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>

    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="url" value="<?php echo $this->createUrl("family/user") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $this->createUrl("family/user",array('fid'=>$fid)) ?>">
      <input type="hidden" id="del" value="<?php echo $this->createUrl("family/del") ?>">
      <input type="hidden" id="fid" value="<?php echo $fid ?>">
      <input type="hidden" id="isanchor" value="<?php echo $isanchor ?>">
       <tr role="row">
		   <th aria-label="家族名称">家族名称</th>
		   <th aria-label="号码">号码</th>
       <th aria-label="用户名">用户名</th>
       <th aria-label="职位">职位</th>
       <th aria-label="是否是主播">是否是主播</th>
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
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker-bs2.css">

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker-bs3.css">

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/moment.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/family/user.js" type="text/javascript"></script>

