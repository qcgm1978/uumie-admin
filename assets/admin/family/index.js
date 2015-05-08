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
	var id = '';
	var val = '';
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"id":id,"page":page,"gid":gid,"username":username},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="7">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.family_name+'</td><td>'+item.family_build_time+'</td><td>'+item.family_update_time+'</td><td>'+item.family_lead+'</td><td>'+item.is_recommend+'</td><td>'+item.family_sign+'</td><td>'+item.operate+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
function del(uid){
	bootbox.confirm("您确定删除该主播吗？", function(result) {
	   if (result) {
	    	var url = $("#del").val();
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
function recommed(fid,status,type){

	var url = $("#updateinfo").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"fid":fid,"status":status,"type":type},
		url:url,
		success:function(result) {
			
			if (result==1) {

				ajax();
			}else{

				bootbox.alert("系统故障");
			}				
		}
	});
	
}
