$(function(){
	$("#fleadNull").hide();
	$("#fnameNull").hide();
	$("#fsignNull").hide();
	$('#reset').click(function(){
		$("#flead").val('');
		
	});

	$("#save").click(function(){ 

		verify();
		var is_flead =  $("#fleadNull").is(":hidden");
		var is_fname =  $("#fnameNull").is(":hidden");
		var is_fsign =  $("#fsignNull").is(":hidden");
		
		var flead = $("#flead").val();

		var url = $("#addUrl").val();	

		if (is_flead && is_fname && is_fsign) {
			ajax(flead,url);
		}
	}); 
	 

});
function verify(){
	var url = $("#url").val();
	var uid = uid;
	var fname = $("#fname").val();
	if (!fname){
		$("#fnameNull").show().html("家族名不能为空");
		return false;
	}else{
		$("#fnameNull").hide();
		checklen(fname);
		var is_name =  $("#fnameNull").is(":hidden");
	}

	var flead = $("#flead").val();
	var fid = $("#fid").val();
	if (!flead){
		$("#fleadNull").show().html("家族长号不能为空");
		return false;
	}else{
		$("#fleadNull").hide();
		saletitle(flead,fid);
	}
	var fsign = $("#fsign").val();
	if (fsign) {
		checklen(fname);
	}
}

function ajax(flead,url){
	var fname = $("#fname").val();
	var announce = $("#announce").val();
	var fdesc = $("#fdesc").val();
	var fsign = $("#fsign").val();
	var fid = $("#fid").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"flead":flead,"fname":fname,"announce":announce,"fdesc":fdesc,"fsign":fsign},
		url:url,
		success:function(result) {
			if (result==0) {
				$("#fleadNull").show().html("该用户已经有家族了");

			}else if (result==1) {
				bootbox.alert("操作成功：添加家族成功");		
			}else if (result==2) {
				bootbox.alert("操作失败：系统故障");		
			}else if (result==3) {
				bootbox.alert("操作成功：编辑家族成功");		
			}else if (result==4) {
				bootbox.alert("操作失败：编辑家族失败");		
			}						
		}
	});
}
function saletitle(gid,fid){

	var url = $("#checkgid").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid,"fid":fid},
		url:url,
		success:function(result) {
			if (result==0) {

				$("#fleadNull").show().html("家族长不存在");
			}						
		}
	});

}
function checklen(username){

	var url = $("#checklen").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"username":username},
		url:url,
		success:function(result) {
			if (result==1) {

				$("#fnameNull").show().html("账号最少2个字符，最多只能是8个汉字或16字母!");
			}else{
				$("#fnameNull").hide();
			}						
		}
	});

}