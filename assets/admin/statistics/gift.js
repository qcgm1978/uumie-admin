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
	
	if (params[0]=='page' || params[1]=='page') {
		page = params[1];
	}else{
		page = 1;
	}
	var getype = $("#getype").val();
	var url = $("#url").val();
	var presenter = $("#presenter").val();
	var recipient = $("#recipient").val();
	var roomid = $("#roomid").val();
	var giftname = $("#giftname").val();
	var uid = $("#uid").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"page":page,"starttime":starttime,"endtime":endtime,"uid":uid,"getype":getype,"presenter":presenter,"recipient":recipient,"roomid":roomid,"giftname":giftname},
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
					var conStr = '<tr><td>'+item.gift_name+'</td><td>'+item.from_nickname+'</td><td>'+item.to_nickname+'</td><td>'+item.gift_sum+'</td><td>'+item.total_price+'</td><td>'+item.room_name+'</td><td>'+item.add_time+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
