$(function(){

	var word = $("#word").val();

	$('#reset').click(function(){
		$("#word").val(word);
		
	});

	$("#save").click(function(){
		var word = $("#word").val();
		var url = $("#url").val();	
		ajax('word_banned',word,url);
	}); 
	 

});

function ajax(id,word,url){
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"id":id,"word":word},
		url:url,
		success:function(result) {
			if (result==1) {
				bootbox.alert("屏蔽词语设置成功");	

			}else if(result==0){
				bootbox.alert("服务器故障或者您未对词语做操作！");	
			}					
		}
	});
	
}