$(function(){
	$("#userNull").hide();

	$('#reset').click(function(){
		$("#username").val('');
		$("#userNull").show().html("用户帐号不能为空");
	});
	
	$("#room_min_user").val($("#minuser").val());
	$("#upload_size_limit").val($("#upzl").val());
	$("#gift_car").val($("#gcar").val());
	var param = $("#param").val().split(",");
	$.each(param,function(i,item){
		$("#"+item).hide();
	});

	$("#save").click(function(){

		var param = $('form').serializeArray();
		ajax(param);
	}); 
	
	 

});


function ajax(param){
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"param":param},
		url:url,
		success:function(result) {
			if (result==1) {
				bootbox.alert("恭喜您更新数据成功");
				
			}else if (result==0) {
				bootbox.alert("数据未做更改或者系统故障");
			}						
		}
	});
}
