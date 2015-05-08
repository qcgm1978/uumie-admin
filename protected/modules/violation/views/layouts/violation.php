<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>U美直播社区后台管理系统</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/umei/index.css"/>
</head>

<body>
<!-- 返回顶部与置顶关注开始
  <div class="rightside">
      <a href="" class="current">置顶<br>关注</a>
      <a href="单个房间监控查看-按场记录索引.html">返回顶部</a>
  </div>
  返回顶部与置顶关注结束-->

<!-- 标题开始 -->
<div class=title><a href="<?php echo Yii::app()->createUrl('admin/default/index') ?>"><h1>U美直播社区后台管理系统</h1></a></div>
<!-- 标题结束 -->

<!-- 功能切换开始 -->
<div class="Switch">
    <a href="<?php echo $this->createUrl("monitor/index") ?>">监控管理</a>
    <a href="审核管理.html">审核管理</a>
    <a href="推荐池子.html">推荐池管理</a>
</div>
<!-- 功能切换结束 -->
<div class="father">
    <!-- 左侧列表开始 -->
    <div class="leftlist">
        <ul class="outer one">
            <li><a href="<?php echo $this->createUrl("monitor/index") ?>">实时监控</a></li>
            <li><a href="<?php echo $this->createUrl("monitor/monitoeviol") ?>">监控违规管理</a></li>
            <li><a href="<?php echo $this->createUrl("monitor/systemrecord") ?>">系统自动记录管理</a>
                <!-- 下级菜单隐藏 -->
                <ul class="outside">
                    <li><a href="<?php echo $this->createUrl("monitor/fieldrecord") ?>">按场记录索引</a></li>
                    <li><a href="<?php echo $this->createUrl("monitor/fieldlive") ?>">某场直播监控查看</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- 左侧列表结束 -->
    <!-- 右侧内容详情开始 -->
    <div class="right">
        <!-- 当前页显示开始 -->
        <div class="currpage">
            <a href="" class="stration">后台管理</a>
<?php echo $content; ?>