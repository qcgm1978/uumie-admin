<div class="span10">
<h4 class="page-title">添加主播</h4>
<a href="<?php echo $this->createUrl("anchor/index") ?>" style="float:right;" class="btn btn-info btn-sm">主播列表</a>
<div class="btn-toolbar">
   <form class="form-inline">
      <label class="input"></label>
       <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> 
    </form>
</div>
<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("anchor/add") ?>">
      <input type="hidden" id="checkGid" value="<?php echo $this->createUrl("anchor/checkgid") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户号码：<input class="input-sm" id="gid" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="gidNull" class="alert alert-warning"></span>
        </label>
        <label></label>               
        <label>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;收款人：<input class="input-sm" id="name" type="text" value="">
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>银行名称：</span><input class="input-sm" id="bankname" type="text">
          </label>
           <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>银行卡号：</span><input class="input-sm" id="banknum" type="text">
          </label>
         <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>支付宝：</span><input class="input-sm" id="alipay" type="text">
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/anchor/add.js" type="text/javascript"></script>
