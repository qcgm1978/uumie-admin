$(function(){

	$("#gidNull").hide();

	var gid = $("#gid").text();
	var name = $("#name").val();
	var bankname = $("#bankname").val();
	var alipay = $("#alipay").val();
	var banknum = $("#banknum").val();

	if (!gid) {
		bootbox.alert("该用户不存在");
		window.history.go(-1);
	}


	


	$('#reset').click(function(){
		$("#bankname").val(bankname);
		$("#banknum").val(banknum);
		$("#name").val(name);
		$("#alipay").val(alipay); 
		
	});
	$("#save").click(function(){ 
		

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


function ajax(gid,url){
	
    var name = $("#name").val();

    var bankname = $("#bankname").val();

    var banknum = $("#banknum").val();

    var alipay = $("#alipay").val();

    var update = $("#update").val();  

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"name":name,"bankname":bankname,"banknum":banknum,"alipay":alipay,"gid":gid,"update":update},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("编辑主播失败！");

			}else{

				bootbox.confirm("编辑主播成功? ", function(result) {
				   
				   window.history.go(-1);
				   
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
