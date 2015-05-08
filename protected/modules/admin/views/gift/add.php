<div class="span10">
<h4 class="page-title" id="title">添加礼物</h4>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/uploadify/uploadify.css">

<div class="well">   
      <input type="hidden" id="url" value="<?php echo $this->createUrl("gift/add") ?>">
      <input type="hidden" id="checkgiftname" value="<?php echo $this->createUrl("gift/checkgiftname") ?>">
      <input type="hidden" id="giftid" value="<?php echo $giftid ?>">
      <input type="hidden" id="giftcat" value="<?php echo $giftcat ?>">
      <input type="hidden" id="gifttype" value="<?php echo $gifttype ?>">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;礼物名称：<input class="input-sm" value="<?php echo $giftname?>" id="giftname" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="nameNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;礼物价格：<input class="input-sm" value="<?php echo $giftprice?>" id="gifprice" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="priceNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;礼物单位：<input class="input-sm" value="<?php echo $giftunit?>" id="giftunit" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="unitNull" class="alert alert-warning"></span>
        </label>
        <label></label>
         
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;礼物分类：<select class="span2" id="catype">
        <option value="0">全部分类</option>
        <?php foreach($info as $k=>$v): ?>
        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
        <?php endforeach ?>
        </select>&nbsp;<span style="color:#FF0000">*</span>
        <label></label>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;显示效果：<select class="span2" id="giftype">
       
        <option value="0">全部显示</option>
        <option value="1">逐行刷屏</option>
        </select>&nbsp;<span style="color:#FF0000">*</span>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;礼物图片&nbsp;Flash：<a id="upload"></a>
        <span style="color:#FF0000">*</span>
        
        <span id="images" class="alert alert-warning"></span>
        <span id="fsh" class="alert alert-warning"></span>
        <input class="input-sm" value="<?php echo $giftimg ?>" id="img" type="hidden">
        <input class="input-sm" value="<?php echo $giftthumb ?>" id="thumb" type="hidden">
        <input class="input-sm" value="<?php echo $giftswf ?>" id="flash" type="hidden">
        </label>  
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;播放时长：<input class="input-sm" value="<?php echo $giftlife?>" id="giftlife" type="text" onblur="verifys()">
        <span style="color:#FF0000">*</span>
        <span id="lifeNull" class="alert alert-warning"></span>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/gift/add.js" type="text/javascript"></script>
<script type="text/javascript">
    
$(function(){
 　　   $('#upload').uploadify({
            auto: true,
            //fileObjName: 'upfile',
       　　 swf      :'/assets/uploadify/uploadify.swf',
            method: 'POST',
     　　　 uploader :'<?php echo $this->createUrl('gift/UploadImg')?>',
            multi: false,
            // buttonText: '浏览',
            'buttonText': '本地上传', //设置按钮文本
            fileTypeDesc: '请选择文件',
            fileTypeExts: '*.jpg; *.jpeg; *.png; *.gif; *.bmp; *.JPG; *.JPEG; *.PNG; *.GIF; *.SWF',
            sizeLimit: 204800,
            formData: {},
        　　 // Put your options here
            onUploadSuccess: function (file, data, response) {
                console.log(data);
                obj = jQuery.parseJSON(data);
                console.log(obj);
                    if (obj.images) {
                        $("#img").val(obj.images);
                        $("#thumb").val(obj.thumb);
                        $("#images").show().html("上传的图片成功");
                    }else if(obj.flash){
                         $("#fsh").show().html("上传的flash成功")
                        $("#flash").val(obj.flash);
                    }             

                }
    　　　});
　　　});
　　
</script>