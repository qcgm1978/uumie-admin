$(function(){

	$("#submit").click(function(){
		
		var carname = $("#carname").val();
		var username = $("#username").val();

		ajax(carname,username);
	})
	ajax();
});
function ajax(carname,username){
	
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
	data:{"page":page,"carname":carname,"username":username},
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
					var conStr = '<tr><td>'+item.car_name+'</td><td>'+item.user_name+'</td><td>'+item.comefrom+'</td><td>'+item.start_time+'</td><td>'+item.expire_time+'</td><td>'+item.expired+'</td><td>'+item.used+'</td><td>'+item.operate+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}

//改变类型
function changetype(id,status,type){

	var url = $("#updatetype").val();
	
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"id":id,"status":status,"type":type},
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

//删除会员
function del(id){

	var url = $("#delUrl").val();
	
	bootbox.confirm("确定删除这个会员的座驾吗？", function(result) {		   
	   if (result) {
	    	$.ajax({
				type:"POST",
				dataType:"json",
				data:{"id":id},
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
