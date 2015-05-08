<div class="span10">
            <h4 class="page-title">编辑分类</h4>

<div class="well">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("room/save") ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分类名称：<input class="input-sm" id="catname" value="<?php if ($chioce['cat_name']) { echo $chioce['cat_name']; } ?>" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="catnameNull" class="alert alert-warning"></span>
        </label>
        <label></label>
         
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上级分类：<select class="span3" id="catype">
        <option value="0">顶级分类</option>
        <?php foreach($info as $v): ?>
        <option value="<?php echo $v['cat_id']; ?>"><?php echo $v['cat_name']; ?></option>
        <?php endforeach ?>
        </select>
        <input type="hidden" id="catparent" value="<?php  echo $chioce['parent_id']; ?>">
        <input type="hidden" id="catid" value="<?php  echo $chioce['cat_id']; ?>">        
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：<input class="input-sm" id="sortorder" type="text" value="<?php if ($chioce['sort_order']) { echo $chioce['sort_order']; } ?>">
        
        </label>
        
          <label> 
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否显示：<input type="radio" checked="checked" name="show"  value="1">&nbsp;&nbsp;是&nbsp;&nbsp;<input type="radio" name="show"  value="0">&nbsp;&nbsp;否
          <input type="hidden" id="showid" value="<?php if ($chioce['is_show']) {
            echo $chioce['is_show'];
          }  ?>">    
         </label>
         <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>超级链接：</span><input class="input-sm" id="sUrl" <?php if ($chioce['link_url']) { echo $chioce['link_url']; } ?>" type="text">
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/room/edit.js" type="text/javascript"></script>
