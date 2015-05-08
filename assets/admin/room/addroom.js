$(function(){
	$("#nameNull").hide();
	$("#catNull").hide();
	$("#serverNull").hide();
	$("#iconNull").hide();
	$("#maxNull").hide();
	$("#room_cat").val($("#catid").val());
	$("#room_server").val($("#serverid").val());
	$("#bitrate").val($("#bid").val());
	$("#agency_uid").val($("#agencyuid").val());
	var roomid = $("#roomid").val();
	var room_icon = $("#room_icon").val();
	if (roomid && !room_icon) {
		$("#iconNull").show().html("未上传图标");
	}else if(roomid && room_icon){
		$("#iconNull").show().html("已上传");
	}
	$('#reset').click(function(){
		$("#username").val('');
		$("#userNull").show().html("用户帐号不能为空");
	});
	$("#save").click(function(){
		verify();
		var room_cat = $("#room_cat").val();
		if (!room_cat) {
			$("#catNull").show().html("请选择房间的分类");
			return false;
		}else{
			$("#catNull").hide();
		}
		var room_server = $("#room_server").val();
		if (!room_server) {
			$("#serverNull").show().html("请选择所在服务器");
			return false;
		}else{
			$("#serverNull").hide();
		}
		var is_name =  $("#nameNull").is(":hidden");	
		var is_server =  $("#serverNull").is(":hidden");	
		var is_cat =  $("#catNull").is(":hidden");	
		var is_max =  $("#maxNull").is(":hidden");	
		if (is_name && is_server && is_cat && is_max) {
			var param = $('form').serializeArray();
			ajax(param,roomid);
		}
	}); 
	
	 

});

function verify(){
	var room_name = $("#room_name").val();
	var roomid = $("#roomid").val();
		
	if (!room_name){
		
		$("#nameNull").show().html("房间名称不能为空");
		return false;
	}else{
		var len = getByteLen(room_name);
        if (len<2 || len>16) {
        	$("#nameNull").show().html("账号最少2个字符，最多只能是8个汉字或16字母!");
        	return false;
        }else{
        	checkRoomName(room_name,roomid);
        }
		
	}
	var max_user = $("#max_user").val();
	if (isNaN(max_user) || max_user > 65535) {
		$("#maxNull").show().html("单个房间最大人数必须为数字且不能超过 65535 人");
	}else{
		$("#maxNull").hide();
	}

}
function checkRoomName(name,roomid){

	var url = $("#roomnameexists").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"name":name,"roomid":roomid},
		url:url,
		success:function(result) {
			if (result==1) {

				$("#nameNull").show().html("房间名称已存在");
			}else if(result==0){
				$("#nameNull").show().html("房间名称最多10个汉字");
			}else{
				$("#nameNull").hide();
			}						
		}
	});

}

function ajax(param,roomid){
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"param":param,"roomid":roomid},
		url:url,
		success:function(result) {
			if (result==1) {
				bootbox.confirm("恭喜您添加房间成功?<br/> 返回上一页请按确定，继续添加请按取消", function(result) {
				   
				   if (result) {
				    	window.history.go(-1);
				   }else{
				 	  	window.history.go(0);
				   }
				   
				});
				
			}else if(result==2){

				bootbox.confirm("恭喜您编辑房间成功? ", function(result) {
				   
				   window.history.go(-1);
				   
				});
			}else if(result==3){
				bootbox.alert("您未更新房间数据或系统故障");
			}else if(result==0){
				// bootbox.alert("系统故障添加失败");
			}else{
				// bootbox.alert("系统故障,操作失败");
			}						
		}
	});
}
function addothercat(){
	var url = $("#getcat").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{},
		url:url,
		success:function(result) {
			console.log(result);
			$("#content").append(result);
			if (result==1) {
				bootbox.alert("恭喜您更新数据成功");
				
			}else if (result==0) {
				bootbox.alert("数据未做更改或者系统故障");
			}						
		}
	});
}
function getByteLen(val) { 
	var len = 0; 
	for (var i = 0; i < val.length; i++) { 
		if (val[i].match(/[^\x00-\xff]/ig) != null) //全角 
		len += 2; 
		else 
		len += 1; 
	} 
	return len; 
} 