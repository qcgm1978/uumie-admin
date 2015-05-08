$(function(){
	$("#gidNull").hide();

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
		var gid = $("#gid").val();
		var catype = $("#catype").val();
		if (catype==0) {
			bootbox.alert("请选择爵位等级");
			return false;
		}
		var saletype = $('input[name="saletype"]:checked').val();
		if (!saletype) {
			bootbox.alert("请选择销售类型");
			return false;
		}
		if (is_gid) {
			ajax(gid,catype,saletype);

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
}


function ajax(gid,catype,saletype){
	
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid,"catype":catype,"saletype":saletype},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("操作失败：用户级别大于你要给它使用的爵位，你可以选择增加到他的道具包，供他赠送用！");

			}else if(result==1){

				bootbox.alert("操作成功：给用户添加爵位等级");
			}else if(result==11){

				bootbox.alert("操作成功：用户级别等于你要给它使用的爵位，给用户续费成功！");
			}else if(result==12){
				
				bootbox.alert("操作成功：用户级别小于你要给它使用的爵位，给用户升级成功！");
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

				$("#gidNull").show().html("用户不存在");
			}						
		}
	});

}
