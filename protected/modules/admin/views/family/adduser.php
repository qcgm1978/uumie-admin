<div class="span10">
            <h4 class="page-title">添加家族成员 </h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("family/adduser") ?>">
      <input type="hidden" id="checkgid" value="<?php echo $this->createUrl("family/checkgid") ?>">
      <input type="hidden" id="fid" value="<?php echo $fid ?>">
      <input type="hidden" id="ptype" value="<?php echo $ptype ?>">
      <input type="hidden" id="atype" value="<?php echo $atype ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
       <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;家族名称：<span id="fname"><?php echo $fname ?></span>

        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户号：<input class="input-sm" value="<?php echo $uid; ?>" id="gid" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="gidNull" class="alert alert-warning"></span>
        </label>
        <label></label>
         <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;职位：<select class="span2" id="ptype">
        <option value="2">管理</option>
        <option value="3">成员</option>
        <option value="4">待批准</option>
        <option value="5">禁止申请</option>
        
        </select></label><label>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;主播：<select class="span2" id="atype">
        <option value="1">否</option>
        <option value="2">是</option>
        
        </select>
        </label>
        
      </div>
  </div>

<?php $form = $this->endWidget(); ?>
</div>

<div class="btn-toolbar">
    <a   id="save" class="btn btn-primary">保存</a>
    <a id="reset" data-toggle="modal1" class="btn">重置</a>
  <div class="btn-group">
  </div>
</div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/family/adduser.js" type="text/javascript"></script>
