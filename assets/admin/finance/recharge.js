$(function(){

	$('#starttime').daterangepicker({
			singleDatePicker: true
		},
		function(start, end, label) {
		});

	$('#endtime').daterangepicker({
			singleDatePicker: true
		},
		function(start, end, label) {
		});


	$("#submit").click(function(){
			var starttime = $("#starttime").val();
			var endtime = $("#endtime").val();
		ajax(starttime,endtime);
	})
	ajax();
});
function ajax(starttime,endtime){
	
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
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"page":page,"starttime":starttime,"endtime":endtime,"uid":uid,"paytype":paytype},
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
