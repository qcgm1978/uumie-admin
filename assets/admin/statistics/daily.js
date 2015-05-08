$(function(){

	$('#starttime').daterangepicker({
			singleDatePicker: true
		},
		function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

	$('#endtime').daterangepicker({
			singleDatePicker: true
		},
		function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
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
	params = url.split("&");
	page = params[1] ? params[1].split("=")[1] : '' ;

	var url = $("#url").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"page":page,"starttime":starttime,"endtime":endtime},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="14">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.add_time+'</td><td>'+item.consume_sum+'</td><td>'+item.pay_scc_sum+'</td><td>'+item.pay_scc_count+'</td><td>'+item.vip_vip_count+'</td><td>'+item.vip_count+'</td><td>'+item.anchor_count+'</td><td>'+item.live_count+'</td><td>'+item.cash_count+'</td><td>'+item.cash_sum+'</td><td>'+item.reg_count+'</td><td>'+item.login_count+'</td><td>'+item.vip_vip_buy_count+'</td><td>'+item.gift_count+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
