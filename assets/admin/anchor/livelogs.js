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
		
		if (endtime < starttime) {

			bootbox.alert("开始时间不能大于结束时间");
			return false;
		}else{
			ajax(starttime,endtime);
		}	
		

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
	var gid = $("#gid").val();
	var roomid = $("#roomid").val();
	var uid = $("#uid").val();
	var url = $("#url").val();
	var val = $("#val").val();
	var name = $("#name").val();

	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"val":val,"name":name,"page":page,"uid":uid,"roomid":roomid,"gid":gid,"starttime":starttime,"endtime":endtime},
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
					var conStr = '<tr><td>'+item.nickname+'</td><td>'+item.seconds+'</td><td>'+item.room_name+'</td><td>'+item.starttime+'</td><td>'+item.endtime+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
function del(uid){
	bootbox.confirm("您确定删除该训管人吗？", function(result) {
	   if (result) {
	    	var url = $("#delwatchman").val();
			$.ajax({
				type:"POST",
				dataType:"json",
				data:{"uid":uid},
				url:url,
				success:function(result) {
					if (result==1) {
						ajax();
					}				
				}
			});
	   }else{
	 	  	// window.history.go(0);
	   }
	});
	
}
