$(function(){
	$('#starttime').daterangepicker({
			singleDatePicker: true
		},
		function(start, end, label) {
		});

	$('#endtime').daterangepicker({
			singleDatePicker: true
		},
		function(start, end, label) {
		});
	$('#rstarttime').daterangepicker({
			singleDatePicker: true
		},
		function(start, end, label) {
		});

	$('#rendtime').daterangepicker({
			singleDatePicker: true
		},
		function(start, end, label) {
		});
	
	var uid = '';
	var username = '';
	

	$("#submit").click(function(){

		var starttime = $("#starttime").val();
		var endtime = $("#endtime").val();

		ajax(starttime,endtime);

	})

	ajax();
});

function ajax(){
	
	var url = window.location.href;
	params = url.split("&");
	page = params[1] ? params[1].split("=")[1] : '' ;

	var url = $("#url").val();
	var username = $("#username").val();
	var nickname = $("#nickname").val();
	var gid = $("#gid").val();
	var comefrom = $("#comefrom").val();
	var starttime = $("#starttime").val();
	var endtime = $("#endtime").val();
	var rstarttime = $("#rstarttime").val();
	var rendtime = $("#rendtime").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"rstarttime":rstarttime,"rendtime":rendtime,"starttime":starttime,"endtime":endtime,"comefrom":comefrom,"username":username,"page":page,"nickname":nickname,"gid":gid},
	url:url,
	success:function(result) {
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="11">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.uid+'</td><td>'+item.gid+'</td><td id="'+item.uid+'">'+item.username+'</td><td>'+item.nickname+'</td><td>'+item.reg_time+'</td><td>'+item.last_login+'</td><td>'+item.last_login_ip+'</td><td>'+item.last_login_server+'</td><td>'+item.comefrom+'</td><td>'+item.userCount+'</td><td>'+item.isVirtul+'</td></tr>';
				$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
function test(uid){
	var uid = uid;
	var username = $("#"+uid).html();
	var url = $("#addvirtual").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"uid":uid,"username":username},
		url:url,
		success:function(result) {
			if (result==1) {
				$("#myModal").modal();
			}				
		}
	});
}