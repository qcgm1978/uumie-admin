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
	var gid = $("#gid").val();
	var url = $("#url").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"page":page,"gid":gid,"username":username},
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
					var conStr = '<tr><td>'+item.gid+'</td><td>'+item.nickname+'</td><td>'+item.bean+'</td><td>'+item.money+'</td><td>'+item.add_time+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
