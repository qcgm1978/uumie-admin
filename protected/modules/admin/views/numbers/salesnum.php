<div class="span10">
            <h4 class="page-title">出售号码</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("numbers/salesnum") ?>">
      <input type="hidden" id="addUrl" value="<?php echo $this->createUrl("numbers/add") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
          <input type="hidden" id="gid" value="<?php echo $number['gid'] ?>">
        <label></label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;所选号码：<?php echo $number['gid'] ?> 
        <label></label>
        <label></label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;出售方式：<input type="radio"  name="salesway" <?php if ($number['sale_type']==1) {
          echo 'checked'; } ?> value="1">&nbsp;&nbsp;金币<input type="radio" name="salesway" <?php if ($number['sale_type']==2) {
          echo 'checked'; } ?> value="2">&nbsp;&nbsp;积分
        <label></label>
        <input type="hidden" id="rid" value="<?php echo $number['sale_type'] ?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;销售价格：
        <input type="text" id="price" value="<?php echo $number['sale_point'] ?>" name="price" onBlur=verify(); class="input-small"> 
        <span style="color:#FF0000">*</span>
        <span id="priceNull" class="alert alert-warning"></span>
        <label></label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格描述：<textarea rows="3" id="remark">
          <?php echo $number['gid_desc'] ?>

        </textarea>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/number/salesnum.js" type="text/javascript"></script>
