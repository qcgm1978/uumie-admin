<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">
		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-0" data-widget-sortable="true" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2> 会员列表 </h2>
				</header>
				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
					</div>
					<!-- end widget edit box -->
	
					<!-- widget content -->
					<div class="widget-body no-padding">
						<!-- 自定义搜索区 -->
						<div class="widget-body-toolbar" style="height:70px;overflow:hidden;">
							<form id="frmSearch" role="form" class="smart-form">
								<div class="global-search-box">
 
									<section class="pull-left no-padding pull-width120" >
										 <label class="onlycarnumtxt" id="label_carnum">帐号</label>
                                    <label class="input">
                                        <input type="text" class="input-sm" id="account" name="account" value=""/>
                                    </label>
										</label>
									</section>
									<section class="pull-left no-padding pull-width120" >
										<label class="">昵称</label>
										<label class="input">
											<input type="text" id="nickname" name="nickname"  class="input-sm">
										</label>
									</section>
									<section class="pull-left no-padding pull-width120" >
										<label class="">登录起始时间</label>
										<label class="input">
											<i class="icon-prepend fa fa-calendar"></i>
											<input name="in_date" type="text" id="loginstarttime" value="2014-02-01" maxlength="10">
	             						 </label>
									</section>
									<section class="pull-left no-padding pull-width120" >
										<label class="">登录结束时间</label>
										<label class="input">
											<i class="icon-prepend fa fa-calendar"></i>
											<input name="in_date" type="text" id="loginendtime" value="2014-02-01" maxlength="10">
	             						 </label>
									</section>
 									<!-- 宽度需要自己调节 pull-width80/100/120...../240 -->
									<section class="pull-left no-padding pull-width120" >
										<label class="">号码</label>
										<label class="input">
											<input type="text" id = "number" name="number" placeholder="" class="input-sm">
										</label>
									</section>
									<section class="pull-left no-padding pull-width120" >
										<label class="">来源</label>
										<label class="input">
											<input type="text" id = "source" name="source" placeholder="" class="input-sm">
										</label>
									</section>
									<section class="pull-left no-padding pull-width120" >
										<label class="">注册起始时间</label>
										<label class="input">
											<i class="icon-prepend fa fa-calendar"></i>
											<input name="in_date" type="text" id="registerstarttime" value="2014-02-01" maxlength="10">
	             						 </label>
									</section>
									<section class="pull-left no-padding pull-width120" >
										<label class="">注册结束时间</label>
										<label class="input">
											<i class="icon-prepend fa fa-calendar"></i>
											<input name="in_date" type="text" id="rgisterendtime" value="2014-02-01" maxlength="10">
	             						 </label>
									</section>
									<div class="global-search-btn" >
	                                    <a id="btnSearch" class="btn btn-primary  btn-sm" type="button"><i class="fa fa-search"></i> 查询</a>
										<a id="btnMoreSearch" class="btn btn-sm btn-link" type="button">更多条件</a>
								    </div>
								</div>
							</form>
						</div>
						
					  <div class="row margin-top-10 margin-bottom-10" style="margin:0">			
						</div>
							<table class="table table-striped table-bordered table-hover has-tickbox dataTable" id="tblMain" aria-describedby="tblMain_info" style="width: 100%;">
						<thead>
							<tr role="row">
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="UID" style="white-space: nowrap;">UID</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="号码" style="white-space: nowrap;">号码</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="帐号" style="white-space: nowrap;">帐号</th><th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="规定补助" style="white-space: nowrap;">规定补助</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="昵称" style="white-space: nowrap;">昵称</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="注册时间" style="white-space: nowrap;">注册时间</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="最后登陆" style="white-space: nowrap;">最后登陆</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="最后登录IP" style="white-space: nowrap;">最后登录IP</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="最后连接服务器" style="white-space: nowrap;">最后连接服务器</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="来源" style="white-space: nowrap;">来源</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="推荐人数" style="white-space: nowrap;">推荐人数</th>
							   <th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1" aria-label="操作" style="white-space: nowrap;">操作</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<tr class="odd">
								<td class="" style="white-space: nowrap;">伊利乳业</td>
								<td class="" style="white-space: nowrap;">YLRY</td>
								<td class="" style="white-space: nowrap;">送货</td>
								<td class="" style="white-space: nowrap;">120.00</td>
								<td class="" style="white-space: nowrap;">小利</td>
								<td class="" style="white-space: nowrap;">13800138001</td>
								<td class="" style="white-space: nowrap;">内蒙古大兴安岭</td>
								<td class=" sorting_1" style="white-space: nowrap;">北京&mdash;大兴</td>
								<td class="" style="white-space: nowrap;">2015-01-15 10:31:51</td>
								<td class="" style="white-space: nowrap;">齐齐哈尔运输分公司</td>
								<td class="" style="white-space: nowrap;">2015-01-15 10:31:51</td>
								<td class="" style="white-space: nowrap;">齐齐哈尔运输分公司</td>
							</tr>
							<tr class="even" style="background-color: rgb(255, 255, 255);">
								<td class="" style="white-space: nowrap;">蒙牛乳业</td>
								<td class="" style="white-space: nowrap;">MNRY</td>
								<td class="" style="white-space: nowrap;">接送货</td>
								<td class="" style="white-space: nowrap;">80.00</td>
								<td class="" style="white-space: nowrap;">小牛</td>
								<td class="" style="white-space: nowrap;">13800138000</td>
								<td class="" style="white-space: nowrap;">内蒙古呼和浩特大草原</td>
								<td class=" sorting_1" style="white-space: nowrap;">北京&mdash;内蒙古</td>
								<td class="" style="white-space: nowrap;">2015-01-15 10:29:00</td>
								<td class="" style="white-space: nowrap;">齐齐哈尔运输分公司</td>
								<td class="" style="white-space: nowrap;">2015-01-15 10:29:00</td>
								<td class="" style="white-space: nowrap;">齐齐哈尔运输分公司</td>
							</tr>
								
							</tbody>
						</table>
	
					</div>
					<!-- end widget content -->
	
				</div>
				<!-- end widget div -->
	
			</div>
			<!-- end widget -->
	
	
		</article>
		<!-- WIDGET END -->
	
	</div>
	<!-- end row -->
</section>

<!-- end widget grid -->
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/default/test.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/js/plugin/date/moment.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/js/plugin/date/daterangepicker.js"></script>
