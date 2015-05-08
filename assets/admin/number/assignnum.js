$(function(){

	$("#gidNull").hide();
	$("#asNull").hide();
	$("#labelid").hide();
	$("#choiceNull").hide();
	var rid = $("#rid").val();

	var operatype = $("#operatype").val();

	if (operatype)  change_sale_type(operatype);

	$('#reset').click(function(){
		$("#gid").val('');
		$("#assignid").val('');
		$("#operatype").val(4);
		change_sale_type(4);
		$("input[name='rid'][value=1]").attr("checked",true); 
		
	});
	$("#save").click(function(){ 
		
		verify();

		var is_gid =  $("#gidNull").is(":hidden");
		var is_as =  $("#asNull").is(":hidden");
		var is_choice =  $("#choiceNull").is(":hidden");

		var gid = $("#gid").val();

		var url = $("#url").val();
		
		if (is_gid && is_as && is_choice) {
			
			ajax(gid,url);

		}else{
			return false;
		}
	}); 
	 

});
function change_sale_type(id){
	
	if (id != 4) {
		
		var sinfo = schoice(id);

		$("#choice").html(sinfo+"：");

		$("#labelid").show();
	}else{
		$("#labelid").hide();
	}
	
}
function verify(){
	
	
	var gid = $("#gid").val();
	var assignid = $("#assignid").val();
	
	if (!gid){
		
		$("#gidNull").show().html("用户号码不能为空");
		return false;
	}
	if(isNaN(gid)){
		
		$("#gidNull").show().html("用户号码不符合类型");
		return false;
	}else{
		
		$("#gidNull").hide();

		var url = $("#checkUrl").val();
		checkNUm(gid,url);
	}
	if (!assignid){
		
		$("#asNull").show().html("分配号码不能为空");
		return false;
	}
	if(isNaN(assignid)){

	    $("#asNull").show().html("分配不符合类型");
	    return false;

	}else{
		
		$("#asNull").hide();
		var url = $("#assignUrl").val();
		checkNUm(assignid,url);
	}
	var is_choice =  $("#labelid").is(":hidden");
	if (!is_choice) {
		verify2();
	}
}

function verify2(){

	var operatype = $("#operatype").val();
	if (operatype< 4) {
		var choiceid = $("#choiceid").val();

		var sinfo = schoice(operatype);
		

		if (!choiceid){
			$("#choiceNull").show().html(sinfo+"不能为空");
			return false;
		}
		
		if(isNaN(choiceid)){
			
			$("#choiceNull").show().html(sinfo+"不符合类型");

			return false;
		}else{

			var url = $("#url").val();

			$("#choiceNull").hide();

			// ajax(gid,url);
		}
	}
}

function schoice(len){

	switch (len){
		case '1':
		  return '扣除优币';
		  break;
		case '2':
		   return '扣除积分';
		  break;
		case '3':
		   return '增加积分';	
		  break;
		}

}

function ajax(gid,url){
	
	var choiceid = $("#choiceid").val();

    var assignid = $("#assignid").val();

    var rid = $("input[name='rid']:checked").val();

    var operatype = $("#operatype").val(); 

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid,"assignid":assignid,"rid":rid,"operatype":operatype,"choiceid":choiceid},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("用户优币余额不足！");

			}else if (result==1) {

				bootbox.alert("用户积分余额不足！");

			}else if (result==2) {

				bootbox.alert("用户积分余额不足！");
			}else if (result==100) {

				bootbox.alert("分配成功");
			}						
		}
	});
}
function checkNUm(id,url){

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"uid":id},
		url:url,
		success:function(result) {
			if (result==0) {

				$("#gidNull").show().html("用户号码不存在");

			}else if (result==3){

				$("#asNull").show().html("号码已经被使用，或者不存在");

			}						
		}
	});
}
