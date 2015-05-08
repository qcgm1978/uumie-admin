<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/umei/css/jcDate.css"/>
<input type="hidden" id="url" value="<?php echo $this->createUrl("monitor/fieldrecord",array('uid'=>$uid)) ?>">
    --<a href="" class="Monitor">单个房间监控查看-按场记录索引</a>
      </div>
    <!-- 当前页显示结束 -->
    <!--搜索栏开始-->
    <div class="select">
        <span style="font-size:12px;">社团：<?php echo $ufname ?>　　主播昵称：<?php echo $username ?>　　主播ID：<?php echo $uid ?></span>
       <span style="float:right;">
        <input id="stime" class="jcDate" style="width:120px;height:15px; line-height:15px; padding:4px;" type="text"/> --
        <input id="etime" class="jcDate" style="width:120px;height:15px; line-height:15px; padding:4px;" type="text"/>
        <input name="" id="sumit" type="button" value="查询" />
        </span>
    </div>
      <!--搜索栏结束-->
      <!--内容开始-->
    <div class="Search fou">
        <ul width="100%" border="0" style="margin-top:10px">
              <?php foreach($info as $v): ?>
              <li>
                  <a href="<?php echo $this->createUrl("monitor/fieldlive",array('uid'=>$v['uid'],'roomid'=>$v['roomid'],'stime'=>$v['start_time'],'etime'=>$v['ender_time'])) ?>"><img src="<?php echo $v['img'] ?>" style="border:1px #ccc solid;"width="80px" height="60px"/></a>
                  <p><?php echo date('Y-m-d',$v['start_time']) ?></p><p><?php echo date('H:i:s',$v['start_time']) ?></p>
              </li>
              <?php endforeach ?>                             
       </ul>

    </div>
    <!--内容结束-->
    <!-- 跳转开始 -->
  <input type="hidden" id="count" value="<?php echo $count ?>">  
  <input type="hidden" id="pageCount" value="<?php echo $pageCount ?>">  
  <input type="hidden" id="page" value="<?php echo $page ?>">  
   <div class="jump">
   </div>
    <!-- 跳转结束 -->
    </div>
  </div>
</body>
</html>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/jquery-1.8.1.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/umei/js/jQuery-jcDate.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/umei/page.js" type="text/javascript"></script>

<script type="text/javascript">
$(function(){


    $("#sumit").click(function(){ 
      var stime = $("#stime").val();

      var etime = $("#etime").val()+' 23:59:59';
      if (!stime || !etime || stime > etime) {
        alert("请选择操作的时间段");
        return false;
      }

      var url = $("#url").val();
      if (stime && etime) {
        url = url+'&stime='+stime+'&etime='+etime;
        location = url;
      }
      
    }); 

});  
</script>
