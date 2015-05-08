$(function(){
	$("#recoverNull").hide();
	
	$('#reset').click(function(){
		$("#recover").val('');
		
	});

	$("#save").click(function(){ 

		verify();
		var is_recover =  $("#recoverNull").is(":hidden");
		
		var recover = $("#recover").val();
		var url = $("#addUrl").val();	

		if (is_recover) {
			ajax(recover,url);
		}
	}); 
	 

});
function verify(){
	var url = $("#url").val();
	var uid = uid;
	var recover = $("#recover").val();
	if (!recover){
		$("#recoverNull").show().html("用户号码不能为空");
		return false;
	}else{
		$("#recoverNull").hide();
	}
}

function ajax(recover,url){

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":recover},
		url:url,
		success:function(result) {
			if (result==0) {
				
				$("#recoverNull").show().html("系统故障，请重试");

			}else if (result==1) {
				bootbox.confirm("恭喜您成功回收号码?<br/> 返回上一页请按确定，继续添加请按取消", function(result) {
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