<div class="span10">
            <h4 class="page-title">编辑会员座驾</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/caruseradd") ?>">
      <input type="hidden" id="checkgid" value="<?php echo $this->createUrl("finance/checkgid") ?>">
      <input type="hidden" id="lurl" value="<?php echo $this->createUrl("finance/caruser") ?>">
      <input type="hidden" id="delid" value="<?php echo $this->createUrl("finance/delid") ?>">
      <input type="hidden" id="carid" value="<?php echo $carid ?>">
       <input type="hidden" id="usercarid" value="<?php echo $id ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
                 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座驾名称：<select class="span2" id="catype">
        
        <?php foreach($info as $v): ?>
        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
        <?php endforeach ?>
        </select>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;会员号码：<input class="input-sm" id="uid" readonly="readonly" type="text" value="<?php echo $uid ?>" >
        <span style="color:#FF0000">*</span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座驾有效期：<input class="input-sm" id="expiretime" type="text" onblur="verify()" value="<?php echo $expiretime; ?>">
        <span style="color:#FF0000">*</span>
        <span id="expireNull" class="alert alert-warning"></span>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/caruseredit.js" type="text/javascript"></script>
