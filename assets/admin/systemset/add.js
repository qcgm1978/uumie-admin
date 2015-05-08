$(function(){
	$("#sidNull").hide();
	$("#snameNull").hide();
	$("#sipNull").hide();
	$("#sportNull").hide();
	$("#snetNull").hide();
	$("#sipsNull").hide();
	$("#sportsNull").hide();
	$("#sportsNull").hide();
	$("#ip2").hide();
	$("#port2").hide();
	var snets = $("#snets").val();
	if (snets=='3') {
		$("#snet").val('3');
		$("#ip2").show();
		$("#port2").show();
	}

	$('#reset').click(function(){
		$("#uid").val('');
		$("#catype").val(0);
		$("#expiretime").val('');
		$("#buytype").val(0);
		
	});
	$("#save").click(function(){ 
		
		verify();
		var is_sid =  $("#sidNull").is(":hidden");
		var is_sname =  $("#snameNull").is(":hidden");
		var is_sip =  $("#sipNull").is(":hidden");
		var is_sport =  $("#sportNull").is(":hidden");		
		if (is_sid && is_sname && is_sip && is_sport) {

			ajax();
		}else{

			return false;
		}
	}); 
	 

});


function verify(){
	var sid = $("#sid").val();
		
	if (!sid){
		$("#sidNull").show().html("集群编号不能为空");
		return false;
	}else{
		checksid(sid);
		$("#sidNull").hide();
	}
	var is_sid =  $("#sidNull").is(":hidden");
	if (!is_sid) {
		return false;
	}
	var sname = $("#sname").val();
		
	if (!sname){
		$("#snameNull").show().html("集群名称不能为空");
		return false;
	}else{
		$("#snameNull").hide();
	}
	var snet = $("#snet").val();
	if (!snet) {
		$("#snetNull").show().html("请选择网络");
		return false;
	}else{
		$("#snetNull").hide();
	}
	var sip = $("#sip").val();
	if (!sip) {
		$("#sipNull").show().html("服务器IP不能为空");
		return false;
	}else{
		$("#sipNull").hide();
	}
	var sport = $("#sport").val();
	if (!sport) {
		$("#sportNull").show().html("端口不能为空");
		return false;
	}else{
		$("#sportNull").hide();
	}
	if (snet=='3') {
		var sips = $("#sips").val();
		if (!sips) {
			$("#sipsNull").show().html("服务器IP2不能为空");
			return false;
		}else{
			$("#sipsNull").hide();
		}
		var sports = $("#sports").val();
		if (!sports) {
			$("#sportsNull").show().html("端口2不能为空");
			return false;
		}else{
			$("#sportsNull").hide();
		}
	}

}



function ajax(){
	var sid = $("#sid").val();
	var sname = $("#sname").val();
	var snet = $("#snet").val();
	var sip = $("#sip").val();
	var sport = $("#sport").val();
	var sips = $("#sips").val();
	var sports = $("#sports").val();
	var sids = $("#sids").val();
	var url = $("#url").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"sid":sid,"sids":sids,"sname":sname,"snet":snet,"sip":sip,"sport":sport,"sips":sips,"sports":sports},
		url:url,
		success:function(result) {
			if (result==1) {
				
				bootbox.confirm("添加服务器成功", function(result) {
					window.history.back(-1);
				});

			}else if(result==0){
				bootbox.alert("系统故障添加服务器失败");	
			}else if(result==3){
				bootbox.alert("编辑服务器失败");
			}else if(result==2){
				bootbox.confirm("编辑服务器成功", function(result) {
					window.history.back(-1);
				});
			}				
		}
	});
}

function checksid(sid){
	var url = $("#cheksid").val();
	var sids = $("#sids").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"sid":sid,"sids":sids},
		url:url,
		success:function(result) {
			if (result==1) {

				$("#sidNull").show().html("集群编号已存在");
			}else{
				$("#sidNull").hide();
			}				
		}
	});
}

function show(id){
	if (id =='3') {
		$("#ip2").show();
		$("#port2").show();
	}else{
		$("#ip2").hide();
		$("#port2").hide();
	}
}
