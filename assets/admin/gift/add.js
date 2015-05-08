$(function(){
	$("#nameNull").hide();
	$("#priceNull").hide();
	$("#unitNull").hide();
	$("#lifeNull").hide();
	$("#thumb").hide();
	
	var images = $("#img").val();
	if (images) {
		$("#title").html('编辑礼物');
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
	var giftcat = $("#giftcat").val();
	if (giftcat) {
		$("#catype").val(giftcat);
	}
	var gifttype = $("#gifttype").val();
	if (gifttype) {
		$("#giftype").val(gifttype);
	}
	$('#reset').click(function(){
		$("#giftname").val('');
		$("#gifprice").val('');
		$("#giftunit").val('');
		$("#giftlife").val('');
		$("#catype").val(0);
		$("#giftype").val(0);
		$("#images").hide();
		$("#fsh").hide();
	});
	$("#save").click(function(){ 

		var giftname = $("#giftname").val();
		var gifprice = $("#gifprice").val();
		var giftunit = $("#giftunit").val();

		var is_name =  $("#nameNull").is(":hidden");
		var is_price =  $("#priceNull").is(":hidden");
		var is_unit =  $("#unitNull").is(":hidden");
		var is_life =  $("#lifeNull").is(":hidden");
		var images = $("#img").val();
		var thumb = $("#thumb").val();
		verify();
		var catype = $("#catype").val();
		if (catype==0) {
			bootbox.alert("请选择礼物分类");
			return false;
		}
		var giftype = $("#giftype").val();
		
		if (!images) {
			$("#images").show().html("请上传礼物图片");
			return false;
		}
		var flash = $("#flash").val();
		if (!flash) {
			$("#fsh").show().html("请上传flash");
			return false;
		}
		verifys();
		var giftlife = $("#giftlife").val();
		if (is_name && is_price && is_unit && is_life) {
			ajax(giftname,gifprice,giftunit,catype,giftype,images,thumb,flash,giftlife);

		}else{

			return false;
		}
	}); 
});

function verify(){
	var giftname = $("#giftname").val();
	var giftid = $("#giftid").val();
		
	if (!giftname){
		
		$("#nameNull").show().html("礼物名称不能为空");
		return false;
	}else{
		checkGiftName(giftname,giftid);
	}
	var gifprice = $("#gifprice").val();

	if (!gifprice){
		
		$("#priceNull").show().html("礼物价格不能为空");
		return false;
	}
	if(isNaN(gifprice)){
		
		$("#priceNull").show().html("礼物价格必须是数字");
		return false;
	}else{
		
		$("#priceNull").hide();
	}
	var giftunit = $("#giftunit").val();

	if (!giftunit){
		
		$("#unitNull").show().html("礼物单位不能为空");
		return false;
	}
	if(!isNaN(giftunit)){
		
		$("#unitNull").show().html("礼物单位不符合类型");
		return false;
	}else{
		
		$("#unitNull").hide();
	}
}
 
function verifys(){
	var giftlife = $("#giftlife").val();

	if (!giftlife){
		
		$("#lifeNull").show().html("播放时长不能为空");
		return false;
	}
	if(isNaN(giftlife)){
		
		$("#lifeNull").show().html("播放时长为数字类型");
		return false;
	}else{
		
		$("#lifeNull").hide();
	}

}


function ajax(giftname,gifprice,giftunit,catype,giftype,images,thumb,flash,giftlife){
	var giftid = $("#giftid").val();
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"giftname":giftname,"giftid":giftid,"gifprice":gifprice,"giftunit":giftunit,"catype":catype,"giftype":giftype,"images":images,"thumb":thumb,"flash":flash,"giftlife":giftlife},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("操作失败：系统故障！");

			}else if(result==1){

				bootbox.confirm("恭喜您成功添加礼物?<br/> 返回上一页请按确定，继续添加请按取消", function(res) {
				   if (res) {
				    	window.history.go(-1);
				   }else{
				 	  	window.history.go(0);
				   }
				});
			}else if(result==3){
				bootbox.confirm("恭喜您成功编辑礼物?<br/>", function(res) {
				   window.history.go(-1);
				});
			}else if(result==2){
				bootbox.alert("更新失败：系统故障！");
			}					
		}
	});
}
function checkGiftName(giftname,giftid){

	var url = $("#checkgiftname").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"giftname":giftname,"giftid":giftid},
		url:url,
		success:function(result) {
			if (result==1) {

				$("#nameNull").show().html("礼物名称已存在");
			}else{
				$("#nameNull").hide();
			}						
		}
	});

}
