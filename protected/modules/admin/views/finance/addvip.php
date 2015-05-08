<div class="span10">
<h4 class="page-title">销售vip</h4>
<a href="<?php echo $this->createUrl("finance/salevip") ?>" style="float:right;" class="btn btn-info btn-sm">Vip会员</a><span style="float:right;">&nbsp;</span>
<div class="btn-toolbar">
   <form class="form-inline">
              
      
        <label ></label>

    </form>
</div>
<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/addvip") ?>">
      <input type="hidden" id="checkgid" value="<?php echo $this->createUrl("finance/checkgid") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;赠送用户号码：<input class="input-sm" id="gid" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="gidNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;推荐用户号码：<input class="input-sm" id="fromid" type="text" onblur="verify()">
        <span id="fromNull" class="alert alert-warning"></span>
        </label>
        <label></label>
         
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VIP等级：<select class="span2" id="catype">
        <option value="0">选择vip等级</option>
        <?php foreach($info as $v): ?>
        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
        <?php endforeach ?>
        </select>
           <span id="catNull" class="alert alert-warning">ffff</span>     
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/addvip.js" type="text/javascript"></script>
