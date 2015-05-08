$(function(){
	$("#userNull").hide();
	$("#pwdNull").hide();
	$("#pwd2Null").hide();
	$('#reset').click(function(){
		$("#username").val('');
		$("#password").val('');
		$("#password2").val('');
	});
	$("#save").click(function(){ 
		verify();
		var is_user =  $("#userNull").is(":hidden");
		var is_pwd =  $("#pwdNull").is(":hidden");
		var is_pwd2 =  $("#pwd2Null").is(":hidden");
		var username = $("#username").val();
		var url = $("#addUrl").val();	
		if (is_user && is_pwd && is_pwd2) {
			console.log(url);
			ajax(username,url);
		}
	}); 
	 

});
function verify(){
	var url = $("#url").val();
	var uid = uid;
	var username = $("#username").val();
	if (!username){
		$("#userNull").show().html("用户帐号不能为空");
		return false;
	}else{
		ajax(username,url);
	} 
	var password = $("#password").val();
	if (!password){
		$("#pwdNull").show().html("用户密码不能为空");
		return false;
	}else{
		 password.length < 6 ? $("#pwdNull").show().html("用户密码至少为6个字符") :$("#pwdNull").hide();
	}
	var password2 = $("#password2").val();
	if (!password2){
		$("#pwd2Null").show().html("确认密码不能为空");
		return false;
	}
	if(password != password2){
		$("#pwd2Null").show().html("两次密码输入不一致，请重新输入");
	}else{
		$("#pwd2Null").hide();
	}
}

function ajax(username,url){
    var virtual = $('input[name="virtual"]:checked').val();
    var password = $("#password").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"username":username,"password":password,"virtual":virtual},
		url:url,
		success:function(result) {
			if (result==1) {
				$("#userNull").show().html("用户名已存在");
			}else if (result==0) {
				$("#userNull").hide();
			}else if (result==3) {
				bootbox.confirm("恭喜您成功添加会员?<br/> 返回上一页请按确定，继续添加请按取消", function(result) {
				   if (result) {
				    	window.history.go(-1);
				   }else{
				 	  	window.history.go(0);
				   }
				});
			}						
		}
	});
}