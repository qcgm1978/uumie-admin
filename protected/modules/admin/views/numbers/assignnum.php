<div class="span10">
            <h4 class="page-title">分配号码</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("numbers/assignnum") ?>">
      <input type="hidden" id="checkUrl" value="<?php echo $this->createUrl("numbers/checknum") ?>">
      <input type="hidden" id="assignUrl" value="<?php echo $this->createUrl("numbers/checkassign") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户号码：<input class="input-sm" id="gid" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="gidNull" class="alert alert-warning"></span>
        </label>
        <label></label>
         <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分配号码：<input class="input-sm" id="assignid" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="asNull" class="alert alert-warning"></span>


        </label>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;操作类型：<select class="span3" id="operatype" onchange="change_sale_type(this.value)">
        <option value="4">免费赠送 -- 免费送万家号码时用到</option>
        <option value="1">扣除优币 -- 玩家用优币购买时用到</option>
        <option value="2">扣除积分 -- 玩家用积分购买时用到</option>
        <option value="3">增加积分 -- 玩家用RMB购买时用到</option>
        </select>
        <label id="labelid">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="choice">分配号码：</span><input class="input-sm" id="choiceid" type="text" onblur="verify2()" >
        <span id="choiceNull" class="alert alert-warning"></span>
          </label>
          <label></label> 
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;自动挂号：<input type="radio" checked="checked" name="rid"  value="1">&nbsp;&nbsp;是&nbsp;&nbsp;<input type="radio" name="rid"  value="0">&nbsp;&nbsp;否
         
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/number/assignnum.js" type="text/javascript"></script>
