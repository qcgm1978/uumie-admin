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

	$("#all").click(function () {
    	
    	$('#btn').removeAttr("disabled");

        var checked_status = this.checked;

        $("input[name=demo]").each(function () {

            this.checked = checked_status;

        });

    });
    $("#sales").click(function () {

    	var sel = $("#selaction").val();

    	if (!sel) {
    		return false;
    	}
    	var str = '';
        var arrChk = $("input[name=demo]:checked");
        
        $(arrChk).each(function () {

            str +="'"+ this.value+"',";

            

        });
        
        str = str.substr(0,str.length-1);
        console.log(str);	
        if (str) {
        	recommed(str,sel,1);
        }else{
        	bootbox.alert("请选择要修改的数据");
        	return false;
        }

    });

	$("#submit").click(function(){

		var starttime = $("#starttime").val();
		var endtime = $("#endtime").val();

		ajax(starttime,endtime);

	})
	ajax();
});
function ajax(starttime,endtime){
	var url = window.location.href;
	params = url.split("&");
	page = params[1] ? params[1].split("=")[1] : '' ;
	var nickname = $("#nickname").val();
	var type = $("#type").val();
	var audit = $("#audit").val();
	var url = $("#listUrl").val();
	// var starttime = $("#starttime").val();
	// var endtime = $("#endtime").val();

	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"nickname":nickname,"page":page,"starttime":starttime,"type":type,"audit":audit,"endtime":endtime},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="8">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{

					var conStr = '<tr><td>'+item.operat+'</td><td>'+item.nickname+'</td><td>'+item.type+'</td><td>'+item.content+'</td><td>'+item.contact+'</td><td>'+item.addtime+'</td><td>'+item.audit+'</td><td>'+item.id+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}

function recommed(id,status,type){

	var url = $("#updateinfo").val();
	
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"id":id,"status":status,"type":type},
		url:url,
		success:function(result) {
			
			if (result==1) {

				ajax();
			}else if( result==2){

				bootbox.alert("恭喜您删除房间成功！");
				ajax();
			}else{

				bootbox.alert("系统故障");
			}				
		}
	});
	
}
function answerlist(){
	var url = $("#answerlist").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{},
		url:url,
		success:function(result) {
			
			if (result==1) {

				bootbox.alert("发布获奖名单成功");
			}else{

				bootbox.alert("您没有执行此项操作的权限");
			}				
		}
	});

}
