<div class="span10">
            <h4 class="page-title">会员座驾添加</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/caruseradd") ?>">
      <input type="hidden" id="checkcar" value="<?php echo $this->createUrl("finance/checkcar") ?>">
      <input type="hidden" id="checkgid" value="<?php echo $this->createUrl("finance/checkgid") ?>">
      <input type="hidden" id="carid" value="<?php echo $carid ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
                 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座驾名称：<select class="span2" id="catype">
        
        <?php foreach($info as $v): ?>
        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
        <?php endforeach ?>
        </select>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;会员号码：<input class="input-sm" id="uid" type="text" onblur="verify()" >
        <span style="color:#FF0000">*</span>
        <span id="uidNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座驾有效期：<input class="input-sm" id="expiretime" type="text" onblur="verifys()">
        <span style="color:#FF0000">*</span>
        <span id="expireNull" class="alert alert-warning"></span>
        </label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;购买方式：<select class="span2" id="buytype">
        
        
        <option value="0">购买</option>
        <option value="1">赠送</option>
        
        </select>

      
        
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/caruserea.js" type="text/javascript"></script>
