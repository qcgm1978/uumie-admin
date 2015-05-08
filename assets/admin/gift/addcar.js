$(function(){
	$("#nameNull").hide();
	$("#priceNull").hide();
	$("#unitNull").hide();
	$("#lifeNull").hide();
	$("#thumb").hide();
	
	var images = $("#img").val();
	if (images) {
		$("#images").show().html("图片已上传");
	}else{
		$("#images").hide();
	}
	var flash = $("#flash").val();
	if (flash) {
		$("#fsh").show().html("flash已上传");
	}else{
		$("#fsh").hide();
	}
	$('#reset').click(function(){
		$("#carname").val('');
		$("#carprice").val('');
		$("#carexpiretime").val('');
		$("#carlife").val('');
		$("#images").hide();
		$("#fsh").hide();
	});
	$("#save").click(function(){ 

		var carname = $("#carname").val();
		var carprice = $("#carprice").val();
		var carexpiretime = $("#carexpiretime").val();

		var is_name =  $("#nameNull").is(":hidden");
		var is_price =  $("#priceNull").is(":hidden");
		var is_unit =  $("#unitNull").is(":hidden");
		var is_life =  $("#lifeNull").is(":hidden");
		var images = $("#img").val();
		var thumb = $("#thumb").val();
		verify();
		
		
		if (!images) {
			$("#images").show().html("请上传座驾图片");
			return false;
		}
		var flash = $("#flash").val();
		if (!flash) {
			$("#fsh").show().html("请上传flash");
			return false;
		}
		verifys();
		var carlife = $("#carlife").val();
		if (is_name && is_price && is_unit && is_life) {
			ajax(carname,carprice,carexpiretime,images,thumb,flash,carlife);

		}else{

			return false;
		}
	}); 
});

function verify(){
	var carname = $("#carname").val();
	var carid = $("#carid").val();
		
	if (!carname){
		
		$("#nameNull").show().html("座驾名称不能为空");
		return false;
	}else{
		checkcarName(carname,carid);
	}
	var carprice = $("#carprice").val();

	if (!carprice){
		
		$("#priceNull").show().html("座驾价格不能为空");
		return false;
	}
	if(isNaN(carprice)){
		
		$("#priceNull").show().html("座驾价格必须是数字");
		return false;
	}else{
		
		$("#priceNull").hide();
	}
	var carexpiretime = $("#carexpiretime").val();

	if (!carexpiretime){
		
		$("#unitNull").show().html("座驾有效期不能为空");
		return false;
	}
	if(isNaN(carexpiretime)){
		
		$("#unitNull").show().html("座驾有效期不符合类型");
		return false;
	}else{
		
		$("#unitNull").hide();
	}
}
 
function verifys(){
	var carlife = $("#carlife").val();

	if (!carlife){
		
		$("#lifeNull").show().html("播放时长不能为空");
		return false;
	}
	if(isNaN(carlife)){
		
		$("#lifeNull").show().html("播放时长为数字类型");
		return false;
	}else{
		
		$("#lifeNull").hide();
	}

}


function ajax(carname,carprice,carexpiretime,images,thumb,flash,carlife){
	var carid = $("#carid").val();
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"carname":carname,"carid":carid,"carprice":carprice,"carexpiretime":carexpiretime,"images":images,"thumb":thumb,"flash":flash,"carlife":carlife},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("操作失败：系统故障！");

			}else if(result==1){

				bootbox.confirm("恭喜您成功添加座驾?<br/> 返回上一页请按确定，继续添加请按取消", function(res) {
				   if (res) {
				    	window.history.go(-1);
				   }else{
				 	  	window.history.go(0);
				   }
				});
			}else if(result==3){
				bootbox.confirm("恭喜您成功编辑座驾?<br/>", function(res) {
				   window.history.go(-1);
				});
			}else if(result==2){
				bootbox.alert("更新失败：系统故障！");
			}					
		}
	});
}
function checkcarName(carname,carid){

	var url = $("#checkcarname").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"carname":carname,"carid":carid},
		url:url,
		success:function(result) {
			if (result==1) {

				$("#nameNull").show().html("座驾名称已存在");
			}else{
				$("#nameNull").hide();
			}						
		}
	});

}
