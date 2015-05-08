$(function(){

	$("#expireNull").hide();

	var showid = $("#showid").val();
	var catparent = $("#catparent").val();
	var catid = $("#carid").val();
	var expiretime = $("#expiretime").val();
	$("#catype").val(catid);


	$('#reset').click(function(){
		$("#gid").val('');
		$("#assignid").val('');
		$("#catype").val(catid);
		$("#expiretime").val(expiretime);
		
	});
	$("#save").click(function(){ 
		
		verify();

		var is_gid =  $("#expireNull").is(":hidden");
		var catype = $("#catype").val();
		var uid = $("#uid").val();
		var expiretime = $("#expiretime").val();
		if (is_gid) {
			ajax(catype,uid,expiretime);

		}else{

			return false;
		}
	}); 
	 

});

function verify(){
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


function ajax(catype,uid,expiretime){
	
	var url = $("#url").val();
	var usercarid = $("#usercarid").val();
	var lurl = $("#lurl").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"uid":uid,"catype":catype,"expiretime":expiretime,"usercarid":usercarid},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("操作失败：用户级别大于你要给它使用的爵位，你可以选择增加到他的道具包，供他赠送用！");

			}else if(result==2){

				bootbox.confirm("编辑成功", function(result) {
					window.history.back(-1);
				});
				
			}else if(result==3){

				bootbox.alert("操作成功：用户级别等于你要给它使用的爵位，给用户续费成功！");
			}					
		}
	});
}
