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
	var starttime = $("#starttime").val();
	var endtime = $("#endtime").val();
	var url = window.location.href;
	var params = url.split("&").pop().split("=");

	if (params[0]=='page' || params[1]=='page') {
		page = params[1];
	}else{
		page = 1;
	}

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
					$("#content").append('<tr><td colspan="8">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.times+'</td><td>'+item.pay_count+'</td><td>'+item.pay_count1+'</td><td>'+item.pay_count2+'</td><td>'+item.pay_count3+'</td><td>'+item.pay_count4+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
