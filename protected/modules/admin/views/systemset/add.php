<div class="span10">
            <h4 class="page-title">服务器列表</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("systemset/add") ?>">
      <input type="hidden" id="cheksid" value="<?php echo $this->createUrl("systemset/cheksid") ?>">
      <input type="hidden" id="snets" value="<?php echo $snet ?>">
      <input type="hidden" id="sids" value="<?php echo $sid ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
                 
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;集群编号：<input class="input-sm" value="<?php echo $snumber ?>"  id="sid" type="text" onblur="verify()" >
        <span style="color:#FF0000">*</span>
        <span id="sidNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;集群名称：<input class="input-sm" value="<?php echo $sname; ?>" id="sname" type="text" onblur="verify()" >
        <span style="color:#FF0000">*</span>
        <span id="snameNull" class="alert alert-warning"></span>
        </label>
       
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选择网络：<select class="span2" value="<?php echo $snet; ?>" id="snet" onchange="show(this.value)">      
        <option value="">请选择</option>
        <option value="1">电信</option>
        <option value="2">联通</option>
        <option value="3">双线</option>
        </select><span style="color:#FF0000">*</span>
        <span id="snetNull" class="alert alert-warning"></span>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;服务器IP：<input class="input-sm" value="<?php echo $sip; ?>" id="sip" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="sipNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;端口：<input class="input-small" value="<?php echo $sport; ?>" id="sport" type="text" onblur="verify()" >
        <span style="color:#FF0000">*</span>
        <span id="sportNull" class="alert alert-warning"></span>
        </label>
        <label id="ip2">
        
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;服务器IP2：<input class="input-sm" value="<?php echo $sips; ?>" id="sips" type="text" onblur="verify()">
        <span style="color:#FF0000">* 联通IP</span>
        <span id="sipsNull" class="alert alert-warning"></span>
        </label>
        <label id="port2">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;端口2：<input class="input-small" value="<?php echo $sports; ?>" id="sports" type="text" onblur="verify()" >
        <span style="color:#FF0000">*</span>
        <span id="sportsNull" class="alert alert-warning"></span>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/systemset/add.js" type="text/javascript"></script>
