$(function(){

	$("#gidNull").hide();

	$('#reset').click(function(){
		$("#gid").val('');
		$("#bankname").val('');
		$("#banknum").val('');
		$("#name").val('');
		$("#alipay").val(''); 
		
	});
	$("#save").click(function(){ 
		
		verify();

		var is_gid =  $("#gidNull").is(":hidden");

		var gid = $("#gid").val();

		var url = $("#url").val();
		
		if (is_gid) {
			
			ajax(gid,url);

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
	}else{

		$("#gidNull").hide();

		checkGid(gid);
	}
}


function ajax(gid,url){
	
    var name = $("#name").val();

    var bankname = $("#bankname").val();

    var banknum = $("#banknum").val();

    var alipay = $("#alipay").val(); 

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"name":name,"bankname":bankname,"banknum":banknum,"alipay":alipay,"gid":gid},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("添加主播失败！");

			}else{

				bootbox.confirm("成功添加主播?<br/> 返回上一页请按确定，继续添加请按取消", function(result) {
				   
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
function checkGid(gid){
	
	var url = $("#checkGid").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid},
		url:url,
		success:function(result) {
			if (result==0) {

				$("#gidNull").show().html("该用户不存在");

			}else if(result==2){

				$("#gidNull").show().html("该用户已经是主播");
			}					
		}
	});
}
