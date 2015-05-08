$(function(){
	$("#gidNull").hide();
	$("#pointNull").hide();
	$("#noteNull").hide();

	$('#reset').click(function(){
		$("#gid").val('');
		$("#point").val('');
		$("#note").val('');
		$("input[name='type'][value=1]").attr("checked",true); 
		
	});
	$("#save").click(function(){ 
		
		verify();

		var is_gid =  $("#gidNull").is(":hidden");
		var is_point =  $("#pointNull").is(":hidden");
		var is_note =  $("#noteNull").is(":hidden");
		var gid = $("#gid").val();
		var catype = $("#catype").val();
		if (is_gid && is_point && is_note) {
			ajax(gid);

		}else{

			return false;
		}
	}); 
	 

});

function verify(){
	var gid = $("#gid").val();
		
	if (!gid){
		
		$("#gidNull").show().html("用户号码不能为空");
		return false;
	}
	if(isNaN(gid)){
		
		$("#gidNull").show().html("用户号码必须是数字");
		return false;
	}else{
		
		$("#gidNull").hide();
		saletitle(gid);
	}
	var point = $("#point").val();
		
	if (!point){
		
		$("#pointNull").show().html("用户号码不能为空");
		return false;
	}
	if(isNaN(point)|| point <= 0){
		
		$("#pointNull").show().html("用户号码必须是数字且大于零");
		return false;
	}else{
		
		$("#pointNull").hide();
	}
	var note = $("#note").val();

	if (!note){		
		$("#noteNull").show().html("请填写操作原因");
		return false;
	}else{
		$("#noteNull").hide();
	}

}


function ajax(gid,catype,saletype){
	
	var point = $("#point").val();
	var note = $("#note").val();
	var type = $('input[name="type"]:checked').val();
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid,"type":type,"point":point,"note":note},
		url:url,
		success:function(result) {
			if (result==1) {

				bootbox.confirm("恭喜您成功扣除U币?<br/> 返回上一页请按确定，继充值请按取消", function(res) {
				   if (res) {
				    	window.history.go(-1);
				   }else{
				 	  	window.history.go(0);
				   }
				});

			}else if(result==2){

				bootbox.confirm("恭喜您成功扣除U豆?<br/> 返回上一页请按确定，继充值请按取消", function(res) {
				   if (res) {
				    	window.history.go(-1);
				   }else{
				 	  	window.history.go(0);
				   }
				});
			}else if(result==3){

				bootbox.confirm("恭喜您成功扣除积分?<br/> 返回上一页请按确定，继充值请按取消", function(res) {
				   if (res) {
				    	window.history.go(-1);
				   }else{
				 	  	window.history.go(0);
				   }
				});
			}					
		}
	});
}
function saletitle(gid){

	var url = $("#checkgid").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid},
		url:url,
		success:function(result) {
			if (result==0) {

				$("#gidNull").show().html("用户号码不存在");
			}						
		}
	});

}
