$(function(){
	$("#userNull").hide();

	$('#reset').click(function(){
		$("#username").val('');
		$("#userNull").show().html("用户帐号不能为空");
	});
	$("#save").click(function(){
	
		verify();
		var is_user =  $("#userNull").is(":hidden");
		var username = $("#username").val();
		var url = $("#addUrl").val();
		console.log(url); 	
		if (is_user) {
			console.log(url);
			ajax(username,url);
		}
	}); 
	 

});
function verify(){
	var url = $("#url").val();
	var uid = uid;
	var username = $("#username").val();
	if(isNaN(username)){
		  $("#userNull").show().html("用户帐号不合法");
		  return false;
	}
	if (!username){
		$("#userNull").show().html("用户帐号不能为空");
		return false;
	}else{
		ajax(username,url);
	} 
}

function ajax(username,url){

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"username":username},
		url:url,
		success:function(result) {
			if (result==1) {
				$("#userNull").hide();
				
			}else if (result==0) {

				$("#userNull").show().html("用户帐号不存在");

			}else if (result==2) {

				$("#userNull").show().html("用户帐号已经是巡管");

			}else if (result==3) {
				
				bootbox.confirm("恭喜您成功添加巡管?<br/> 返回上一页请按确定，继续添加请按取消", function(result) {
				   if (result) {
				    	window.history.go(-1);
				   }else{
				   		$("#username").val('');
				 	  	window.history.go(0);
				   }
				});
			}						
		}
	});
}