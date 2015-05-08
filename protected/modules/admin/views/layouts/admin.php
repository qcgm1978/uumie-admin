<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>U美</title>
    <?php $name =  Yii::app()->controller->id;?>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/stylesheets/theme.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/font-awesome/css/font-awesome.css">

    <script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/jquery-1.8.1.min.js" type="text/javascript"></script>

    <!-- Demo page code -->
    
    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="javascripts/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7"> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8"> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9"> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
  <!--<![endif]-->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <ul class="nav pull-right">
                    
                    <li id="fat-menu" class="dropdown">
                        <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> <?php echo Yii::app()->user->name ?>
                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="<?php echo $this->createUrl('systemset/syset') ?>">设置</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="<?php echo $this->createUrl('login/out') ?>">退出</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="<?php echo $this->createUrl('default/index') ?>"><span class="first">北京</span> <span class="second">星烨互动娱乐</span><span class="first">科技有限公司</span></a>
            </div>
        </div>
    </div>
    

    <div class="container-fluid">
        
        <div class="row-fluid">
            <div class="span2">
                <div class="sidebar-nav">
                  <div class="<?php if ($name =='room') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#dashboard-menu"><i class="icon-dashboard"></i>房间管理</div>
                    <ul id="dashboard-menu" class="<?php if ($name =='room') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                        <li><a href="<?php echo $this->createUrl('room/classify') ?>">房间分类</a></li>
                        <li ><a href="<?php echo $this->createUrl('room/list') ?>">房间列表</a></li>                        
                    </ul>
                <div class="<?php if ($name =='numbers') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#number-menu"><i class="icon-exclamation-sign"></i>号码销售</div>
                <ul id="number-menu" class="<?php if ($name =='numbers') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                  <li ><a href="<?php echo $this->createUrl('numbers/index') ?>">号库管理</a></li>
                  <li ><a href="<?php echo $this->createUrl('numbers/saleinnum') ?>">在售号码</a></li>
                  <li ><a href="<?php echo $this->createUrl('numbers/numsold') ?>">已售号码</a></li>
                  <li ><a href="<?php echo $this->createUrl('numbers/assignnum') ?>"><span style="color:#ff0000">分配号码</span></a></li>
                  <li ><a href="<?php echo $this->createUrl('numbers/recover') ?>"><span style="color:#0000ff">回收号码</span></a></li>
                </ul>
                <div class="<?php if ($name =='user') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#member-menu"><i class="icon-legal"></i>会员管理</div>
                <ul id="member-menu" class="<?php if ($name =='user') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>  ">
                  <li ><a href="<?php echo $this->createUrl('user/add') ?>">添加会员</a></li>
                  <li ><a href="<?php echo $this->createUrl('user/list') ?>">会员列表</a></li>
                  <li ><a href="<?php echo $this->createUrl('user/watchman') ?>">巡管列表</a></li>
                  <li ><a href="<?php echo $this->createUrl('user/virtual') ?>">虚拟人库</a></li>
                </ul>
                <div class="<?php if ($name =='anchor') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#anchor-menu"><i class="icon-exclamation-sign"></i>主播管理</div>
                <ul id="anchor-menu" class="<?php if ($name =='anchor') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>  ">
                  <li ><a href="<?php echo $this->createUrl('anchor/index') ?>">主播列表</a></li>
                  <li ><a href="<?php echo $this->createUrl('anchor/cash') ?>">兑换记录</a></li>
                  <li ><a href="<?php echo $this->createUrl('anchor/apply') ?>">主播申请</a></li>
                </ul>

                <div class="<?php if ($name =='finance') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#finance-menu"><i class="icon-briefcase"></i>财务管理</div>
                 <ul id="finance-menu" class="<?php if ($name =='finance') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>  ">
                  <li ><a href="<?php echo $this->createUrl('finance/pay') ?>">会员充值</a></li>
                  <li ><a href="<?php echo $this->createUrl('finance/payoff') ?>">账户扣除</a></li>
                  <li ><a href="<?php echo $this->createUrl('finance/recharge') ?>"><span style="color:#ff0000">充值记录</span></a></li>
                  <li ><a href="<?php echo $this->createUrl('finance/recon') ?>">充值对账</a></li>
                  <li ><a href="<?php echo $this->createUrl('finance/titlemem') ?>">爵位会员</a></li>
                  <li ><a href="<?php echo $this->createUrl('finance/caruser') ?>">座驾会员</a></li>
                  <li ><a href="<?php echo $this->createUrl('finance/salevip') ?>">VIP会员</a></li>
                </ul>    
                <div class="<?php if ($name =='statistics') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#accounts-menu"><i class="icon-briefcase"></i>数据统计</div>
                <ul id="accounts-menu" class="<?php if ($name =='statistics') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                  <li ><a href="<?php echo $this->createUrl('statistics/gift') ?>">礼物记录</a></li>
                  <li ><a href="<?php echo $this->createUrl('anchor/livelogs') ?>">麦时统计</a></li>
                  <li ><a href="<?php echo $this->createUrl('statistics/daily') ?>">每日统计</a></li>
                </ul>
				       <div class="<?php if ($name =='gift') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#gift-menu"><i class="icon-legal"></i>礼物道具</div>
                <ul id="gift-menu" class="<?php if ($name =='gift') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                  <li ><a href="<?php echo $this->createUrl('gift/list') ?>">礼物管理</a></li>
                  <li ><a href="<?php echo $this->createUrl('gift/charm') ?>">主播等级</a></li>
                  <li ><a href="<?php echo $this->createUrl('gift/car') ?>">座驾管理</a></li>
                </ul>
                <div class="<?php if ($name =='systemlog') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#system-menu"><i class="icon-exclamation-sign"></i>系统优化</div>
                <ul id="system-menu" class="<?php if ($name =='systemlog') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                  <li ><a href="<?php echo $this->createUrl('systemlog/index') ?>">管理员日志</a></li>
                </ul>
				        <div class="<?php if ($name =='systemset') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#setting-menu"><i class="icon-exclamation-sign"></i>系统设置</div>
                <ul id="setting-menu" class="<?php if ($name =='systemset') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                  <li ><a href="<?php echo $this->createUrl('systemset/syset') ?>">参数配置</a></li>
                  <li ><a href="403.html">支付方式</a></li>
                  <li ><a href="<?php echo $this->createUrl('systemset/server') ?>">服务器端</a></li>
                  <li ><a href="<?php echo $this->createUrl('systemset/word') ?>">词语屏蔽</a></li>
                </ul>
                <div class="<?php if ($name =='family') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#family-menu"><i class="icon-legal"></i>家族管理</div>
                <ul id="family-menu" class="<?php if ($name =='family') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                  <li ><a href="<?php echo $this->createUrl('family/index') ?>">家族列表</a></li>
                  <li ><a href="<?php echo $this->createUrl('family/add') ?>">添加家族</a></li>
                </ul>
                <div class="<?php if ($name =='activity') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#legal-menu"><i class="icon-legal"></i>活动管理</div>
                <ul id="legal-menu" class="<?php if ($name =='activity') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                  <li ><a href="<?php echo $this->createUrl('activity/index') ?>">活动反馈审核列表</a></li>
                </ul>
                <div class="<?php if ($name =='monitor') {echo 'nav-header';}else{echo 'nav-header collapsed';} ?>" data-toggle="collapse" data-target="#monitor-menu"><i class="icon-legal"></i>监控管理</div>
                <ul id="monitor-menu" class="<?php if ($name =='monitor') {echo 'nav nav-list collapse in';}else{echo 'nav nav-list collapse';} ?>">
                  <li ><a href="<?php echo Yii::app()->createUrl('violation/monitor/index') ?>">实时监控</a></li>
                </ul>
            </div>
        </div>
	   <?php echo $content ?>
    </div>
    

    
    <footer>
        <hr>
          <p class="pull-right"> <a href="http://www.ummie.com/" title="北京星烨互动娱乐科技有限公司" target="_blank">北京星烨互动娱乐科技有限公司</a> </p>
        
        
        <p>&copy; 2015 <a href="#">U美</a></p>
    </footer>
    <script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/12.js"></script>

  </body>
</html>


