$(function(){


	$("#submit").click(function(){
		
		var gid = $("#gid").val();

		if (isNaN(gid)) {

			bootbox.alert("号码不符合要求");
			
			return false;
		}
		
		if ($('#allgid').is(':checked') && !gid) {

			bootbox.alert("号码不能为空");
			
			return false;
		}else{
			var allgid = 1
		}

		
		ajax(allgid);

	})
	ajax();
});
function ajax(allgid){
	var url = window.location.href;
	params = url.split("&");
	page = params[1] ? params[1].split("=")[1] : '' ;
	var goodnum = $("#goodnum").val();
	var saleway = $("#saleway").val();
	var gid = $("#gid").val();
	var url = $("#listUrl").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"goodnum":goodnum,"page":page,"gid":gid,"saleway":saleway,"allgid":allgid},
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

					var conStr = '<tr><td>'+item.gid+'</td><td>'+item.gid_length+'</td><td>'+item.sale_type+'</td><td>'+item.sale_point+'</td><td>'+item.nickname+'</td><td>'+item.sale_time+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}

