<div class="span10">
            <h4 class="page-title">添加会员</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("user/userunique") ?>">
      <input type="hidden" id="addUrl" value="<?php echo $this->createUrl("user/add") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label><?php echo $form->labelEx($userForm,'username');?> </label>
        <input type="text" id="username" name="username" onBlur=verify(); class="input-xlarge">
        <span id="userNull" class="alert alert-warning"></span>
        <label><?php echo $form->labelEx($userForm,'password');?></label>
       <input type="password" id="password" name="password" onBlur=verify(); class="input-xlarge">
        <span id="pwdNull" class="alert alert-warning"></span>
        <label><?php echo $form->labelEx($userForm,'password2');?></label>
        <input type="password" id="password2" name="password2" onBlur=verify(); class="input-xlarge">        <span id="pwd2Null" class="alert alert-warning"></span>
        <label><?php echo $form->labelEx($userForm,'virtual');?></label>
          <input type="radio" checked="checked" name="virtual" id="virtual1" value="0">
          <i></i>否
          <input type="radio" name="virtual" id="virtual2" value="1">
          <i></i>是
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
 
<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete Confirmation</h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
  </div>
</div>

        </div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/user/add.js" type="text/javascript"></script>
