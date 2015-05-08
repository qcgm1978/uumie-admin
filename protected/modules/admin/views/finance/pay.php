<div class="span10">
            <h4 class="page-title">用户充值</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/pay") ?>">
      <input type="hidden" id="checkgid" value="<?php echo $this->createUrl("finance/checkgid") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户号码：<input class="input-sm" id="gid" type="text" onblur="verify()">

        <span id="gidNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;充值金额：<input class="input-sm" id="money" type="text" onblur="verify()">
        <span style="color:#FF0000">*&nbsp;注意：填写 RMB！</span>
        <span id="moneyNull" class="alert alert-warning"></span>
        </label>
        <label></label>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;销售类型：<input type="radio" checked name="addintegral"  value="0">&nbsp;&nbsp;不加&nbsp;&nbsp;<input type="radio" name="addintegral"  value="1">&nbsp;&nbsp;赠加&nbsp;&nbsp;<font color="#0000ff">* 此设置对普通玩家有效，代理始终不增加积分</font>
        <label></label>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;代理折扣：<input type="radio" checked name="openagency"  value="0">&nbsp;&nbsp;不用&nbsp;&nbsp;<input type="radio" name="openagency"  value="1">&nbsp;&nbsp;启用&nbsp;&nbsp; <font color="#0000ff">* 如果启用，该用户是代理则按照代理折扣充值。</font>
         <label></label>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;充值方式：<input type="radio" checked name="freegive"  onclick="change(this.value)" value="1">&nbsp;&nbsp;免费赠送&nbsp;&nbsp;<input type="radio" name="freegive" onclick="change(this.value)" value="0">&nbsp;&nbsp;现金充值&nbsp;&nbsp;
        
      </div>
  </div>

<?php $form = $this->endWidget(); ?>
</div>

<div class="btn-toolbar">
    <a  id="save" class="btn btn-primary">免费赠送？</a>
    <a id="reset" data-toggle="modal1" class="btn">重置</a>
  <div class="btn-group">
  </div>
</div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/pay.js" type="text/javascript"></script>
