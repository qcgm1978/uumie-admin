<div class="span10">
    <h4 class="page-title">充值记录</h4>
    <a href="" onclick="del()" style="float:right;" class="btn btn-info btn-sm">清理无效订单</a><span style="float:right;">&nbsp;</span>
<div class="btn-toolbar">
   <form class="form-inline">
         <label>方式：</label><select class="span2" id="paytype">
        <option value="">全部方式</option>
        <option value="支付宝">支付宝</option>
        <option value="现金充值">现金充值</option>
        <option value="易宝支付">易宝支付</option>
        <option value="网银在线">网银在线</option>
        <option value="免费赠送">免费赠送</option>
        </select>      
        <label >&nbsp;&nbsp;号码：&nbsp;&nbsp;</label><input type="text" id="gid" class="input-small"> 
        <label >&nbsp;&nbsp;</label>
        <label >&nbsp;&nbsp;订单号：&nbsp;&nbsp;</label><input type="text" id="orderid" class="input-sm"> 
        <label >&nbsp;&nbsp;</label>
      <label >&nbsp;&nbsp;&nbsp;&nbsp;</label> <button id="submit" class="btn" type="button"><i class="icon-search"></i> 搜索</button>

    </form>
</div>
<div class="well">
    <table class="table">
      <thead>
      <input type="hidden" id="delUrl" value="<?php echo $this->createUrl("finance/del") ?>">
      <input type="hidden" id="url" value="<?php echo $this->createUrl("finance/recajax") ?>">
      <input type="hidden" id="listUrl" value="<?php echo $url ?>">
      <input type="hidden" id="reconid" value="<?php echo $reconid; ?>">
      <input type="hidden" id="uid" value="<?php echo $uid; ?>">
       <tr role="row">
		   <th aria-label="订单号">订单号</th>
		   <th aria-label="昵称">昵称</th>
       <th aria-label="来源">来源</th>
       <th aria-label="方式">方式</th>
       <th aria-label="金额">金额</th>
       <th aria-label="购买">购买</th>
       <th aria-label="充值时间">充值时间</th>
       <th aria-label="操作人">操作人</th>
		</tr>
      </thead>
      <tbody id="content">
      	
      </tbody>
        
    </table>
</div>

<div class="pagination">
  <div style="float:left;">
    <ul>
      <li class="active"><a>全站总金额：<span id="totalamount"></span>元， 查询总额：<span id="queryamount"></span>元 ， 分页总额：<span id="amountcount"></span>元</a></li>
    </ul>
   
  </div>
	<div style="float:right;">
	    <ul id="pagination">
	    </ul>
    </div>
</div>

</div>

<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/page.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/finance/recon.js" type="text/javascript"></script>

