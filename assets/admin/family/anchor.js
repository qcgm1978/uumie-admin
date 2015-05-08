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
			
		ajax();
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
	
	var starttime = $("#starttime").val();
	var endtime = $("#endtime").val();
	var fid = $("#fid").val();
	var isanchor = $("#isanchor").val();
	var url = $("#url").val();
	
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"page":page,"starttime":starttime,"endtime":endtime,"fid":fid,"isanchor":isanchor},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="5">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.fname+'</td><td>'+item.gid+'</td><td>'+item.uname+'</td><td>'+item.icome+'</td><td>'+item.live_count+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
