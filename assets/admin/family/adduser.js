$(function(){
	$("#gidNull").hide();

	var ptype = $("#ptype").val();
	var atype = $("#atype").val();
	if (ptype && atype) {
		$("#ptype").val(ptype);
		$("#atype").val(atype);
		var status = 1;

	}else{
		$("#ptype").val(3);
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

		if (is_gid) {
			ajax(status);

		}else{

			return false;
		}
	}); 
	 

});

function verify(){
	var gid = $("#gid").val();
		
	if (!gid){
		
		$("#gidNull").show().html("用户号不能为空");
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


function ajax(status){
	var gid = $("#gid").val();
	var fid = $("#fid").val();
	var ptype = $("#ptype").val();
	var atype = $("#atype").val();
	
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid,"fid":fid,"ptype":ptype,"atype":atype,"status":status},
		url:url,
		success:function(result) {
			if (result==0) {

				$("#gidNull").show().html("该用户已经有家族了");

			}else if(result==1){

				bootbox.alert("操作成功：给家族添加成员成功");
			}else if(result==2){

				bootbox.alert("系统故障：给家族添加成员失败！");
			}else if(result==3){
				
				bootbox.alert("操作成功：编辑家族成员成功！");
			}else if(result==4){
				
				bootbox.alert("编辑失败，数据未改动或系统故障");
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
