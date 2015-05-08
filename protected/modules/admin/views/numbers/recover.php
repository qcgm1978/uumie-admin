<div class="span10">
            <h4 class="page-title">回收号码</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("number/recover") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>用户号码：
        <input type="text" id="recover" name="recover" onBlur=verify(); class="input-xlarge">
        <span style="color:#FF0000">*</span>  
        <span id="recoverNull" class="alert alert-warning"></span>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/number/recover.js" type="text/javascript"></script>
