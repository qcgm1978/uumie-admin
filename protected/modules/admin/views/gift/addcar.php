<div class="span10">
<h4 class="page-title" id="title">添加座驾</h4>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/uploadify/uploadify.css">

<div class="well">   
      <input type="hidden" id="url" value="<?php echo $this->createUrl("gift/addcar") ?>">
      <input type="hidden" id="checkcarname" value="<?php echo $this->createUrl("gift/checkgiftname") ?>">
      <input type="hidden" id="carid" value="<?php echo $carid ?>">
     

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座驾名称：<input class="input-sm" value="<?php echo $carname?>" id="carname" type="text" onblur="verify()">
        <span style="color:#FF0000">*</span>
        <span id="nameNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座驾价格：<input class="input-sm" value="<?php echo $carprice?>" id="carprice" type="text" onblur="verify()">
        &nbsp;币<span style="color:#FF0000">*</span>
        <span id="priceNull" class="alert alert-warning"></span>
        </label>
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座驾有效期：<input class="input-sm" value="<?php echo $carexpiretime?>" id="carexpiretime" type="text" onblur="verify()">
        &nbsp;天<span style="color:#FF0000">*</span>
        <span id="unitNull" class="alert alert-warning"></span>
        </label>
        <label></label>  
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;座驾图片&nbsp;Flash：<a id="upload"></a>
        <span style="color:#FF0000">*</span>
        
        <span id="images" class="alert alert-warning"></span>
        <span id="fsh" class="alert alert-warning"></span>
        <input class="input-sm" value="<?php echo $carimg ?>" id="img" type="hidden">
        <input class="input-sm" value="<?php echo $carthumb ?>" id="thumb" type="hidden">
        <input class="input-sm" value="<?php echo $carswf ?>" id="flash" type="hidden">
        </label>  
        <label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;播放时长：<input class="input-sm" value="<?php echo $carlife?>" id="carlife" type="text" onblur="verifys()">
         &nbsp;秒<span style="color:#FF0000">*</span>
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

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/gift/addcar.js" type="text/javascript"></script>
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