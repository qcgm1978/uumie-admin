<input type="hidden" id="url" value="<?php echo $this->createUrl("monitor/systemrecord") ?>">
<input type="hidden" id="uids" value="<?php echo $uid ?>">
    --<a href="" class="Monitor">系统自动记录管理</a>
      </div>
    <!-- 当前页显示结束 -->
    <!--搜索栏开始-->
    <div class="select">
        <input type="text" id="uid" value="请输入主播ID/名称" width="150px" height="20px"/>
        <input name="" type="submit" id="sumit" value="查询" />
    </div>
      <!--搜索栏结束-->
      <!--内容开始-->
    <div class="Search thr">
       <ul width="100%" border="0" style="margin-top:10px">
              <?php foreach($info as $v): ?>
              <li>
                  <a href="<?php echo $this->createUrl("monitor/fieldrecord",array('uid'=>$v['uid'])) ?>"><img src="<?php echo Yii::app()->request->baseUrl."/upload/avatar/".$v['avatar'] ?>" style="border:1px #ccc solid;"width="80px" height="60px"/></a>
                  <p><?php echo $v['uid'] ?></p>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/jquery-1.8.1.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/monitor/systemrecord.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/umei/js/jQuery-jcDate.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/umei/page.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){

        $("#uid").click(function(){
            $("#uid").val('');
        });

        $("#sumit").click(function(){

            var url = $("#url").val();
            var uid = $("#uid").val();

            if (uid) {
                url = url+'&uid='+uid;
                location = url;
            }else{
                alert("请输入主播的id");
                return false;
            }


        });
    });
</script>
</html>
