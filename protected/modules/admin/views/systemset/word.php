<div class="span10">
<h4 class="page-title">词语屏蔽</h4>
<input type="hidden" id="url" value="<?php echo $this->createUrl("systemset/word") ?>">
<textarea class="span12" id="word" style="height:240px;"><?php echo $word ?></textarea> 
<label>屏蔽词语用"|" 线隔开</label>
<label>替换前的内容可以使用限定符 x 以限定相邻两字符间可忽略的文字，x 是忽略字符的个数</label>
<label>例如： "a{1}s{2}s"(不含引号) 可以屏蔽 "ass" 也可屏蔽 "axsxs" 和 "axsxxs" 等等</label>
<div class="btn-toolbar">
    <a   id="save" class="btn btn-primary">保存</a>
    <a id="reset" data-toggle="modal1" class="btn">重置</a>
  <div class="btn-group">
  </div>
</div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/systemset/word.js" type="text/javascript"></script>
