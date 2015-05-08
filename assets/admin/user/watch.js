$(function(){

	$("#submit").click(function(){
		ajax();

	})
	ajax();
});
function ajax(page){
	var url = window.location.href;
	params = url.split("&");
	page = params[1] ? params[1].split("=")[1] : '' ;
	var username = $("#username").val();
	var uid = $("#uid").val();
	var url = $("#url").val();
	var id = '';
	var val = '';
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"id":id,"page":page,"uid":uid,"username":username},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="3">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.gid+'</td><td>'+item.nickname+'</td><td>'+item.answer+'</td></tr>';
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
