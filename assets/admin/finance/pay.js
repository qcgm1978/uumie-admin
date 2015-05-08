$(function(){
	$("#gidNull").hide();
	$("#moneyNull").hide();

	$('#reset').click(function(){
		$("#gid").val('');
		$("#money").val('');
		$("input[name='openagency'][value=0]").attr("checked",true); 
		$("input[name='addintegral'][value=0]").attr("checked",true); 
		$("input[name='freegive'][value=1]").attr("checked",true); 
		
	});
	$("#save").click(function(){ 
		
		verify();

		var is_gid =  $("#gidNull").is(":hidden");
		var gid = $("#gid").val();
		var is_money =  $("#moneyNull").is(":hidden");
		var money = $("#money").val();
		
		
		if (is_gid && is_money) {
			ajax(gid,money);

		}else{

			return false;
		}
	}); 
	 

});
function change(id){
	// alert(id);
	if (id =='1') {
		$("#save").text("免费赠送？");
	}else{
		$("#save").text("现金充值？");		
	}
}

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
	var money = $("#money").val();
	if (!money){
		
		$("#moneyNull").show().html("充值金额不能为空");
		return false;
	}
	if(isNaN(money) || money <= 0){
		
		$("#moneyNull").show().html("充值金额必须是数字且大于零");
		return false;
	}else{
		
		$("#moneyNull").hide();
	}
}


function ajax(gid,money){
	var addintegral = $('input[name="addintegral"]:checked').val();
	var openagency = $('input[name="openagency"]:checked').val();
	var freegive = $('input[name="freegive"]:checked').val();
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid,"money":money,"freegive":freegive,"addintegral":addintegral,"openagency":openagency},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("系统故障，操作失败！");

			}else if(result==1){
				bootbox.confirm("恭喜您用户充值成功?<br/> 返回上一页请按确定，继充值请按取消", function(res) {
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
