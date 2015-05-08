$(function(){
	$("#n40").hide();


});



function del(catid){
		
  var url = $("#url").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"catid":catid},
		url:url,
		success:function(result) {
			if (result==0) {

				bootbox.alert("删除房间失败！");

			}					
		}
	});
}
