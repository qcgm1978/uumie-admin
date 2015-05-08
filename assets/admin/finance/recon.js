$(function(){

	$("#submit").click(function(){
		
		var orderid = $("#orderid").val();

		ajax(orderid);
	})
	ajax();
});
function ajax(orderid){
	
	var url = window.location.href;
	var params = url.split("&").pop().split("=");
	
	if (params[0]=='page') {
		page = params[1];
	}else{
		page = 1;
	}
	var paytype = $("#paytype").val();
	var url = $("#url").val();
	var uid = $("#uid").val();
	var reconid = $("#reconid").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"page":page,"reconid":reconid,"orderid":orderid,"uid":uid,"paytype":paytype},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
				$("#amountcount").text(item.amount_count);
				$("#totalamount").text(item.total_amount);
				$("#queryamount").text(item.query_amount);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="8">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.order_sn+'</td><td>'+item.nickname+'</td><td>'+item.comefrom+'</td><td>'+item.pay_name+'</td><td>'+item.amount+'</td><td>'+item.addcoin+'</td><td>'+item.add_time+'</td><td>'+item.op_nickname+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
//清理无效订单
function del(){
	var url = $("#delUrl").val;
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"uid":uid},
		url:url,
		success:function(res) {
			if (res==1) {
				ajax();
			}				
		}
	});
}
