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
					$("#content").append('<tr><td colspan="3">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr><td>'+item.starid+'</td><td>'+item.star_name+'</td><td>'+item.min_points+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
function modifyinfo(startid,type){

	switch(type){
		case 1:
			var constr = '请输入您要修改的头衔名称！';
		  break;
		case 2:
		  	var constr = '请输入您要修改的升级点数！';
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
						data:{"startid":startid,"status":result,"type":type},
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