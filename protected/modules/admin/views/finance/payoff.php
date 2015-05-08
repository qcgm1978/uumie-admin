<div class="span10">
            <h4 class="page-title">扣除账户</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/payoff") ?>">
      <input type="hidden" id="checkgid" value="<?php echo $this->createUrl("finance/checkgid") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户号码：<input class="input-sm" id="gid" type="text" onblur="verify()">
         <span style="color:#FF0000">*&nbsp;</span>
        <span id="gidNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;扣除数量：<input class="input-sm" id="point" type="text" onblur="verify()">
         <span style="color:#FF0000">*&nbsp;</span>
        <span id="pointNull" class="alert alert-warning"></span>
        </label>
        <label> </label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;操作类型：<input type="radio" checked name="type"  value="1">&nbsp;&nbsp;扣除U币&nbsp;&nbsp;<input type="radio" name="type"  value="2">&nbsp;&nbsp;扣除U豆&nbsp;&nbsp;<input type="radio" name="type"  value="3">&nbsp;&nbsp;扣除积分
         
        <label>&nbsp;</label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;操作原因：<textarea id="note" class="span4" onblur="verify()"></textarea>
        <span style="color:#FF0000">*&nbsp;</span>
        <span id="noteNull" class="alert alert-warning"></span>
                     

        
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/payoff.js" type="text/javascript"></script>
