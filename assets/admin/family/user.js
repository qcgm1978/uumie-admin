$(function(){

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
	
	var fid = $("#fid").val();
	var url = $("#url").val();
	
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"page":page,"fid":fid},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="6">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.fname+'</td><td>'+item.gid+'</td><td>'+item.uname+'</td><td>'+item.type+'</td><td>'+item.isanchor+'</td><td>'+item.operate+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
function del(uid,fid){

	bootbox.confirm("您确定删除该家族成员吗？", function(result) {
	   if (result) {
	    	var url = $("#del").val();
			$.ajax({
				type:"POST",
				dataType:"json",
				data:{"uid":uid,"fid":fid},
				url:url,
				success:function(result) {
					if (result==1) {
						bootbox.alert("删除家族成员成功");
						ajax();
					}				
				}
			});
	   }else{
	 	  	// window.history.go(0);
	   }
	});
	
}
