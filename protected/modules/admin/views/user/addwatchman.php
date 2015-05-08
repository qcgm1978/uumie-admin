<div class="span10">
    <h4 class="page-title">添加巡管</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("user/iswatchman") ?>">
      <input type="hidden" id="addUrl" value="<?php echo $this->createUrl("user/addwatchman") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label><?php echo $form->labelEx($watchForm,'username');?> </label>
        <input type="text" id="username" name="username" onBlur=verify(); class="input-xlarge">
        <span id="userNull" class="alert alert-warning"></span>        
      </div>
      <div class="tab-pane fade" id="profile">
        <label>New Password</label>
        <input type="password" class="input-xlarge">
        <div>
            <button class="btn btn-primary">Update</button>
        </div>
   
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

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/user/addwatchman.js" type="text/javascript"></script>
