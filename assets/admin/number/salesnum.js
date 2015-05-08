$(function(){
	$("#priceNull").hide();

	var rid = $("#rid").val();
	// $("input[name='salesway'][value="+rid+"]").attr("checked",true); 

	$('#reset').click(function(){
		
		$("#price").val('');
		$("#remark").val('');

		
	});
	$("#save").click(function(){ 
		verify();
		var is_price =  $("#priceNull").is(":hidden");
		
		var gid = $("#gid").val();
		var url = $("#url").val();

		if (is_price) {
			
			ajax(gid,url);
		}
	}); 
	 

});
function verify(){
	var url = $("#url").val();
	var price = $("#price").val();
	if (!price){
		$("#priceNull").show().html("销售价格不能为空");
		return false;
	}
	if(isNaN(price)){
		  $("#priceNull").show().html("销售价格必须是数字");
		  return false;
	}else{
		$("#priceNull").hide();
	}
}

function ajax(gid,url){
	
	var remark = $("#remark").val();

    var gid = $("#gid").val();

    var price = $("#price").val();

    var salesway = $("input[name='salesway']:checked").val(); 
   

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"gid":gid,"price":price,"salesway":salesway,"remark":remark},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("更新成功");

			}else if (result==1) {

				bootbox.confirm("恭喜您更新成功 ?", function(result) {
				
				   window.history.go(-1);
				   
				});
			}						
		}
	});
}