<div class="span10">
            <h4 class="page-title">添加分类</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/addtitle") ?>">
      <input type="hidden" id="checkgid" value="<?php echo $this->createUrl("finance/checkgid") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户号码：<input class="input-sm" id="gid" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="gidNull" class="alert alert-warning"></span>
        </label>
        <label></label>
         
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;爵位等级：<select class="span2" id="catype">
        <option value="0">选择爵位等级</option>
        <?php foreach($info as $v): ?>
        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
        <?php endforeach ?>
        </select>
                     
          <label> </label>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;销售类型：<input type="radio" name="saletype"  value="1">&nbsp;&nbsp;只加等级&nbsp;&nbsp;<input type="radio" name="saletype"  value="2">&nbsp;&nbsp;到道具包&nbsp;&nbsp;<input type="radio" name="saletype"  value="3">&nbsp;&nbsp;完全使用
         
        
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/addtitle.js" type="text/javascript"></script>
