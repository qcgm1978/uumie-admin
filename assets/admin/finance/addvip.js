$(function(){
	$("#gidNull").hide();
	$("#fromNull").hide();
	$("#catNull").hide();

	var showid = $("#showid").val();
	var catparent = $("#catparent").val();


	
	if (catparent) {
		$("#catype").val(catparent);
	}


	$('#reset').click(function(){
		$("#gid").val('');
		$("#assignid").val('');
		$("#catype").val(0);
		$("input[name='rid'][value=1]").attr("checked",true); 
		
	});
	$("#save").click(function(){ 
		
		verify();

		var is_gid =  $("#gidNull").is(":hidden");
		var is_from =  $("#fromNull").is(":hidden");
		var is_cat =  $("#catNull").is(":hidden");
		var gid = $("#gid").val();
		var fromid = $("#fromid").val();
		var catype = $("#catype").val();
		if (catype==0) {
			$("#catNull").show().html("请选择VIP等级");
			return false;
		}else{
			$("#catNull").hide();
		}
		
		if (is_gid && is_from && is_cat) {
			ajax(gid,fromid,catype);

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
	var fromid = $("#fromid").val();
	if (fromid && isNaN(fromid)) {
		$("#fromNull").show().html("推荐用户号码必须是数字");
		return false;
	}else{
		$("#fromNull").hide();
	}
	
}


function ajax(gid,fromid,catype){
	
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid,"catype":catype,"fromid":fromid},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("操作失败！");

			}else if(result==1){

				bootbox.confirm("操作成功", function(result) {
					window.history.back(-1);
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
				
				$("#gidNull").show().html("赠送用户号码不存在");
				
			}						
		}
	});

}
