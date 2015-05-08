$(function(){
	$("#uidNull").hide();
	$("#expireNull").hide();

	var showid = $("#showid").val();
	var catparent = $("#catparent").val();
	$("#catype").val(carid = $("#carid").val());

	
	if (catparent) {
		$("#catype").val(catparent);
	}


	$('#reset').click(function(){
		$("#uid").val('');
		$("#catype").val(0);
		$("#expiretime").val('');
		$("#buytype").val(0);
		
	});
	$("#save").click(function(){ 
		
		verify();
		verifys();

		var is_uid =  $("#uidNull").is(":hidden");
		var is_expiretime =  $("#expireNull").is(":hidden");
		var uid = $("#uid").val();
		var catype = $("#catype").val();
		var expiretime = $("#expiretime").val();
		
		
		if (is_uid && is_expiretime) {
			ajax(uid,catype,expiretime);

		}else{

			return false;
		}
	}); 
	 

});

function verify(){
	var uid = $("#uid").val();
		
	if (!uid){
		
		$("#uidNull").show().html("会员号码不能为空");
		return false;
	}
	if(isNaN(uid)){
		
		$("#uidNull").show().html("会员号码必须是数字");
		return false;
	}else{
		
		$("#uidNull").hide();
		checkcar(uid);
	}
}
function verifys(){
	var expiretime = $("#expiretime").val();
	if (!expiretime){
		
		$("#expireNull").show().html("座驾有效期不能为空");
		return false;
	}
	if(isNaN(expiretime)){
		
		$("#expireNull").show().html("座驾有效期必须是数字");
		return false;
	}else{
		
		$("#expireNull").hide();
	}
}


function ajax(uid,catype,expiretime){
	
	var url = $("#url").val();
	var buytype = $("#buytype").val();
	$.ajax({
	type:"POST",
		dataType:"json",
		data:{"uid":uid,"catype":catype,"expiretime":expiretime,"buytype":buytype},
		url:url,
		success:function(result) {
			if (result==2) {
				
				bootbox.confirm("会员添加座驾成功", function(result) {
					window.history.back(-1);
				});

			}					
		}
	});
}
function checkcar(uid){

	var url = $("#checkcar").val();
	var catype = $("#catype").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"uid":uid,"catype":catype},
		url:url,
		success:function(result) {
			if (result==0) {

				$("#uidNull").show().html("该会员已经有这个座驾了！");
			}						
		}
	});

}
