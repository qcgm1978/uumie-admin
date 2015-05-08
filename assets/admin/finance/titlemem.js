$(function(){

	$("#submit").click(function(){
		
		var gid = $("#gid").val();

		ajax(gid);
	})
	ajax();
});
function ajax(gid){
	
	var url = window.location.href;
	var params = url.split("&").pop().split("=");
	
	if (params[0]=='page') {
		page = params[1];
	}else{
		page = 1;
	}

	var url = $("#url").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"page":page,"gid":gid},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="9">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.gid+'</td><td>'+item.nickname+'</td><td>'+item.comefrom+'</td><td>'+item.vip_name+'</td><td>'+item.type+'</td><td>'+item.start_time+'</td><td>'+item.expire_time+'</td><td>'+item.is_expire+'</td><td>'+item.operate+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}

//删除会员
function del(uid){

	var url = $("#delUrl").val();
	
	bootbox.confirm("您确定删除VIP会员吗？", function(result) {		   
	   if (result) {
	    	$.ajax({
				type:"POST",
				dataType:"json",
				data:{"uid":uid},
				url:url,
				success:function(res) {
					if (res==1) {
						ajax();
					}				
				}
			});
	   }
	   
	});
	
}
