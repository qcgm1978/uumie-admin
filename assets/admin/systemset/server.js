$(function(){
	ajax();
});
function ajax(page){

	var url = $("#listUrl").val();

	$.ajax({
	type:"POST",
	dataType:"json",
	data:{},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				var conStr = '<tr><td>'+item.number+'</td><td>'+item.name+'</td><td>'+item.type+'</td><td>'+item.host+'</td><td>'+item.port+'</td><td>'+item.rooms+'</td><td>'+item.operate+'</td></tr>';

				$("#content").append(conStr);
				
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
function del(sid){

	var url = $("#updateinfo").val();

	bootbox.confirm("您确定删除该服务器吗？", function(result) {
		if (result) {

			$.ajax({
				type:"POST",
				dataType:"json",
				data:{"sid":sid},
				url:url,
				success:function(result) {
					
					if ( result==2){

						bootbox.alert("恭喜您删除服务器成功！");
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
