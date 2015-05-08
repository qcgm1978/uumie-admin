$(function(){

	$('#reset').click(function(){
		$("#virtualguest").val('');
		$("#virtualuser").val('');
		$("#time").val(0);
		
	});

	$("#save").click(function(){ 
		
		verify();
	}); 
	 
});

function verify(){

	var virtualguest = $("#virtualguest").val();

	var virtualuser = $("#virtualuser").val();

	var url = $("#url").val();

	if (!virtualguest || !virtualuser) {

		bootbox.alert("虚拟会员和虚拟游客不能全部为0！");
		return false;
	}else{

		ajax(virtualguest,url,virtualuser);
	}
}

function ajax(virtualguest,url,virtualuser){

    var roomid = $("#roomid").val();

    var time = $("#time").val();

    var roomname = $("#roomname").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"virtualguest":virtualguest,"time":time,"virtualuser":virtualuser,"roomid":roomid,"roomname":roomname},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("更新房间失败！");

			}else{

				bootbox.confirm("更新房间成功！?<br/> 返回上一页请按确定，继续添加请按取消", function(result) {
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
