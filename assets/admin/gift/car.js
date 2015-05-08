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
	var goodnum = $("#goodnum").val();
	var saleway = $("#saleway").val();
	var giftname = $("#giftname").val();
	var catpye = $("#catpye").val();
	var giftype = $("#giftype").val();

	var url = $("#listUrl").val();

	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"giftype":giftype,"page":page,"giftname":giftname,"catpye":catpye},
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

					var conStr = '<tr><td>'+item.name+'</td><td>'+item.price+'</td><td>'+item.expire_time+'</td><td>'+item.is_hidden+'</td><td>'+item.type+'</td><td>'+item.sort_order+'</td><td>'+item.operate+'</td></tr>';

					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}

function recommed(carid,status,type){

	var url = $("#updateinfo").val();
	
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"carid":carid,"status":status,"type":type},
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
function del(carid,status,type){

	var url = $("#updateinfo").val();

	bootbox.confirm("您确定删除该座驾吗？", function(result) {
		if (result) {

			$.ajax({
				type:"POST",
				dataType:"json",
				data:{"carid":carid,"status":status,"type":type},
				url:url,
				success:function(result) {
					
					if ( result==2){

						bootbox.alert("恭喜您删除礼物成功！");
						ajax();
					}else{

						bootbox.alert("系统故障");
					}				
				}
			});
		}
	});
}

function modifyinfo(carid,type){

	switch(type){
		case 1:
			var constr = '请输入您要修改的座驾名称！';
		  break;
		case 2:
		  	var constr = '请输入您要修改的价格！';
		  break;
		case 3:
		  var constr = '请输入您要修改的排序值！';
		  break;
		
	}
	var url = $("#updateinfo").val();
	bootbox.prompt(constr, function(result) {

            if (result === null) {                                             
                                             
            } else {
            	if (result){
            		$.ajax({
						type:"POST",
						dataType:"json",
						data:{"carid":carid,"status":result,"type":type},
						url:url,
						success:function(result) {
							if (result==1) {
								ajax();
							}				
						}
					});   
            	}              
            }
        });
		
}
