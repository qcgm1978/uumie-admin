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
function ajax(starttime,endtime,exp){
	
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
					$("#content").append('<tr><td colspan="8">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.realname+'</td><td>'+item.phone+'</td><td>'+item.qq+'</td><td>'+item.area+'</td><td>'+item.content+'</td><td>'+item.likes+'</td><td>'+item.time+'</td><td>'+item.add_time_str+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
