$(function(){
	var uid = '';
	var username = '';
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
	var uid = $("#uid").val();
	var url = $("#url").val();
	var id = '';
	var val = '';
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"id":id,"page":page,"uid":uid,"username":username},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="6">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					var conStr = '<tr id="'+item.uid+'"><td>'+item.uid+'</td><td class="uname" style="cursor:pointer;color:#0088cd">'+item.username+'</td><td>'+item.reg_time+'</td><td>'+item.last_login+'</td><td>'+item.last_login_ip+'</td><td>'+item.answer+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});
		$(".uname").click(function(){
    	
		        var td = $(this); 
		        var txt = $.trim(td.text()); 
		        var input = $("<input type='text'value='" + txt + "'/>"); 
		        td.html(input);
		        input.click(function () { return false; });
		 
		        input.trigger("focus");
		        var id = $(this).closest('tr').attr("id");
		       
		        input.blur(function () {
	            var newtxt = $(this).val(); 
	            var len = getByteLen(newtxt);
	            if (len<2 || len>16) {
	            	bootbox.alert("账号最少2个字符，最多只能是8个汉字或16字母!");
	            	return false;
	            }
	            if (newtxt != txt) {
	                td.html(newtxt);
	                if (modifyName(id,newtxt)) {
	                	td.html(newtxt); 
	                }

	            }else{
	            	td.html(txt); 
	            } 
	            
	        }); 

	    });		
	}



	});
}
function del(uid){
	bootbox.confirm("您确定删除该虚拟人吗？", function(result) {
	   if (result) {
	    	var url = $("#delvirtual").val();
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
	   }
	});
	
}
function modifyName(uid,result){
	var url = $("#editVirtual").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"uid":uid,"username":result},
		url:url,
		success:function(result) {
			if (result==1) {
				ajax();
			}				
		}
	});  
		
}
function getByteLen(val) { 
	var len = 0; 
	for (var i = 0; i < val.length; i++) { 
		if (val[i].match(/[^\x00-\xff]/ig) != null) //全角 
		len += 2; 
		else 
		len += 1; 
	} 
	return len; 
}