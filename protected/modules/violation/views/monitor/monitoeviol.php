<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/umei/css/jcDate.css"/>
<input type="hidden" id="url" value="<?php echo $this->createUrl("monitor/monitoeviol",array('uid'=>$uid,'stime'=>$stime,'etime'=>$etime)) ?>">

    --<a href="" class="Monitor">违规截图管理</a>
        </div>
        <!-- 当前页显示结束 -->
        <!--搜索栏开始-->
        <form>
        <div class="select">
            <input type="text" name="uid" id="uid" value="请输入主播ID/名称" width="150px" height="20px"/>

            <label for="select"></label>&nbsp;&nbsp;
            <select name="select" id="type">
                <option value="">请选择处理结果</option>
                <option value="0">警告</option>
                <option value="1">踢出房间</option>
            </select>&nbsp;&nbsp;&nbsp;
            <input id="stime" class="jcDate" style="width:120px;height:15px; line-height:15px; padding:4px;" type="text"/> --
            <input id="etime" class="jcDate" style="width:120px;height:15px; line-height:15px; padding:4px;" type="text"/>
            <input name="" id="sumit" type="button" value="查询" />
        </div>
        </form>
        <!--搜索栏结束-->
        <!--内容开始-->
        <div class="Search sen">
            <ul width="100%" border="0">
                <?php foreach($info as $v): ?>
                <li><?php  ?>
                    <img src="<?php echo IMG_PATH.'201803'.'/'.substr(preg_replace('/\D/s', '', $v['images']), 0,8).'/'.$v['images']; ?>" style="border:1px #ccc solid;"width="480px" height="360px"/>
                    <p>社团：<?php echo $v['family_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;主播：<?php echo $v['username']; ?>&nbsp;&nbsp;&nbsp;&nbsp;主播ID：<?php echo $v['uid'] ?> </p>
                    <p>时间：<?php echo date('Y-m-d H:i:s',$v['createtime']);?> </p>
                    <p class="ti">处理结果：<?php echo $v['type'] ? '踢出房间15分钟':'警告'; ?></p>
                </li>
                <?php endforeach; ?>
            </ul>

        </div>
        <!--内容结束-->
        <!-- 跳转开始 -->
  <input type="hidden" id="count" value="<?php echo $count ?>">  
  <input type="hidden" id="pageCount" value="<?php echo $pageCount ?>">  
  <input type="hidden" id="page" value="<?php echo $page ?>">        <div class="jump">
        </div>
        <!-- 跳转结束 -->
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/jquery-1.8.1.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/umei/js/jQuery-jcDate.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/umei/page.js" type="text/javascript"></script>

</body>
</html>
<script type="text/javascript">
    $(function(){
        $("#uid").click(function(){
            $("#uid").val('');
        });
        $("#sumit").click(function(){ 
            var mtime= mtype = muid = '';
            var stime = $("#stime").val();
            
            var etime = $("#etime").val();

            if ((stime && !etime) || (!stime && etime) || (parseInt(stime.substring(7)) > parseInt(etime.substring(7)))) {
               alert("请选择操作的时间段");
               return false;
            }else{
                if (stime && etime) {
                    etime = $("#etime").val()+' 23:59:59';
                    var mtime = '&stime='+stime+'&etime='+etime;
                }
            }
            var type = $("#type").val();
            if (type!='') {
                var mtype = '&type='+type
            }
            var uid = $("#uid").val();
            if (!isNaN(uid)) {
                var muid = '&uid='+uid
            }            

            var url = $("#url").val();
            
            if (muid || mtype || mtime) {
                url = url+muid+mtype+mtime;
                console.log(url);return false;
                location = url;
            }else{
                alert('请选择要查询的信息');
                return false;
            }
        }); 

    });
</script>