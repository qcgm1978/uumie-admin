$(function(){

	$("#all").click(function () {
    	
    	$('#btn').removeAttr("disabled");

        var checked_status = this.checked;

        $("input[name=demo]").each(function () {

            this.checked = checked_status;

        });

    });
    $("#delted").click(function () {
    	var str = '';
        var arrChk = $("input[name=demo]:checked");
        
        $(arrChk).each(function () {

            str += this.value+',';

            

        });
        if (!str) {
        	return false;
        }
        
        str = str.substr(0,str.length-1);
        del(str);

    });

	$("#submit").click(function(){
		
		var mingid = $("#mingid").val();
		var maxgid = $("#maxgid").val();
		
		if (mingid &&  maxgid && mingid > maxgid) {

			bootbox.alert("号码段不符合要求");
			
			return false;
		}
		ajax();

	})
	$("#clear").click(function(){
		
		var clear = $("#logdate").val();

		if (clear) {
			del(clear);
		}else{
			return false;
		}
		
		ajax();

	})
	ajax();
});
function ajax(page){
	var url = window.location.href;
	var params = url.split("&").pop().split("=");
	if (params[0]=='page' || params[1]=='page') {
		page = params[1];
	}else{
		page = 1;
	}

	var uid = $("#uid").val();
	var gid = $("#gid").val();
	var url = $("#url").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"uid":uid,"page":page,"gid":gid},
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

					var conStr = '<tr><td>'+item.operat+'</td><td>'+item.log_id+'</td><td>'+item.nick_name+'</td><td>'+item.log_time+'</td><td>'+item.ip_address+'</td><td>'+item.log_info+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}

function del(logid){

	var url = $("#delog").val();
	bootbox.confirm("您确定删除该日志吗？", function(result) {
		if (result) {
			$.ajax({
				type:"POST",
				dataType:"json",
				data:{"logid":logid},
				url:url,
				success:function(result) {
					
					if ( result==2){

						bootbox.alert("恭喜您删除日志成功！");
						ajax();
					}else{

						bootbox.alert("系统故障");
					}				
				}
			});
		}
	});
}

