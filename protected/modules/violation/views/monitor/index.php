<!-- 返回顶部与置顶关注开始 -->
<div class="rightside">
    <a href="javascript:" class="current J_stick">置顶关注</a>
    <a href="javascript:" class="J_top">返回顶部</a>
</div>
<!-- 左侧列表结束 -->
<input type="hidden" id="url" value="<?php echo $this->createUrl("monitor/CheckRoomLive") ?>">
<input type="hidden" id="viol" value="<?php echo $this->createUrl("monitor/violation") ?>">
--<a href="" class="Monitor">实时监控</a>
</div>
<!-- 当前页显示结束 -->

<!-- 内容详情开始 -->
<div class="Search">
    <ul width="100%" border="0" class="J_wrap_ul">

        <?php foreach ($info as $v): ?>

            <li>
                <a href="javascript:void(0)"><img class="J_watch_img" src="<?php echo $v['img']; ?>"
                                                  data-effective_src="<?php echo $v['img']; ?>"
                                                  data-uid="<?php echo $v['uid']; ?>"
                                                  data-room_id="<?php echo $v['room_id']; ?>"/></a>

                <p>社团：<?php echo $v['family_name']; ?></p>

                <p>主播：<?php echo $v['username']; ?>　　房间ID：<?php echo $v['room_id']; ?></p>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="发出警告" class="J_operate J_warn"/>
                &nbsp;&nbsp;
                <input type="button" value="踢出房间" class="J_operate"/>
            </li>
        <?php endforeach ?>

    </ul>
</div>
<!-- 内容详情结束 -->
</div>
<!-- 右侧详情页结束 -->
</div>
<script type="text/html" id="J_template">

    <a href="javascript:">
        <img class="J_watch_img" data-template-bind='[
     {"attribute": "src", "value": "img"},
     {"attribute": "data-effective_src", "value": "img"},
     {"attribute": "data-uid", "value": "uid"},
     {"attribute": "data-room_id", "value": "room_id"}
     ]'>
    </a>

    <p>社团：<span data-content="family_name"></span></p>

    <p>主播：<span data-content="username" style="margin-right: 30px;"></span>房间ID：<span data-content="room_id"></span>
    </p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" value="发出警告" class="J_operate J_warn">
    &nbsp;&nbsp;
    <input type="button" value="踢出房间" class="J_operate">

</script>
<script type="text/javascript">
    var aid = "<?php echo $aid ?>";
    var gurl = "<?php echo $this->createUrl("monitor/index") ?>";
</script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/jquery-1.8.1.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/jquery.loadTemplate-1.4.5.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/monitor/index.js"></script>
</body>
</html>
