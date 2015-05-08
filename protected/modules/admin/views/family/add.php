<div class="span10">
            <h4 class="page-title">添加家族</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("number/fname") ?>">
      <input type="hidden" id="checkgid" value="<?php echo $this->createUrl("family/checkgid") ?>">
      <input type="hidden" id="checklen" value="<?php echo $this->createUrl("user/CheckNameLen") ?>">
      <input type="hidden" id="fid" value="<?php echo $fid ?>">
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>&nbsp;&nbsp;&nbsp;家族名：
        <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" onBlur=verify(); class="input-sm">
        <span style="color:#FF0000">*</span>  
        <span id="fnameNull" class="alert alert-warning"></span>
        </label>
        <label>家族长号：
        <input type="text" id="flead" value="<?php echo $flead; ?>" name="flead" onBlur=verify(); class="input-sm">
        <span style="color:#FF0000">*</span>  
        <span id="fleadNull" class="alert alert-warning"></span>
        </label>
         <label>家族公告：
        <textarea id="announce" class="span6" style="height:120px;"><?php echo $announce; ?></textarea>

        </label>
         <label>家族说明：
        <textarea id="fdesc" class="span6" style="height:120px;"><?php echo $fdesc; ?></textarea>

        </label>
        <label>家族徽章：
        <input type="text" id="fsign" value="<?php echo $fsign; ?>" name="flead" class="input-sm">
         <span id="fsignNull" class="alert alert-warning"></span>


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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/family/add.js" type="text/javascript"></script>
