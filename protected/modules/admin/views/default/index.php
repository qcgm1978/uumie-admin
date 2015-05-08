<div class="span9">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/javascripts/graphDemo.js"></script>


<h4 class="page-title">管理首页</h4>

<div class="row-fluid">
    <div class="block span12">
        <div class="block-heading" data-toggle="collapse" data-target="#widget2container">订单信息</div>
        <div id="widget2container" class="block-body collapse in">
            <table class="table">
              <tbody>
                 <tr>
					<th>已完成订单：</th>
					<td><?php echo $sscpay ?></td>
					<th>无效订单数：</th>
					<td><?php echo $invpay ?></td>
				</tr>
              </tbody>
            </table>
        </div>
    </div>
   
</div>

<div class="row-fluid">
    <div class="block span12">
        <div class="block-heading" data-toggle="collapse" data-target="#tablewidget">系统信息</div>
        <div id="tablewidget" class="block-body collapse in">
            <table class="table">
              <tbody>
					<tr>
						<th>操作系统：</th>
						<td><?php echo PHP_OS ;?></td>
						<th>Web 服务器：</th>
						<td><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>
					</tr>
					<tr>
						<th>PHP版本 ：</th>
						<td><?php echo PHP_VERSION ?></td>
						<th>Mysql 版本：</th>
						<td><?php echo substr(mysql_get_client_info(), 0,14) ?></td>
					</tr>
					<tr>
						<th>Socket 支持:</th>
						<td><?php echo function_exists('fsockopen') ? '是' : '否'; ?></td>
						<th>时区设置: </th>
						<td><?php echo function_exists("date_default_timezone_get") ? date_default_timezone_get() : '无';?></td>
					</tr>
					<tr>
						<th>GD 版本:</th>
						<td><?php echo function_exists('imagecreate')? '是' : '否' ?></td>
						<th> Zlib 支持: </th>
						<td><?php echo function_exists('gzclose') ? '是' : '否' ?></td>
					</tr>
				</tbody>
            </table>
        </div>
    </div>
</div>


        </div>