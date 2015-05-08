$(function(){
	$("#catnameNull").hide();

	var showid = $("#showid").val();
	var catparent = $("#catparent").val();


	
	if (catparent) {
		$("#catype").val(catparent);
	}


	$('#reset').click(function(){
		$("#catname").val('');
		$("#assignid").val('');
		$("#catype").val(0);
		$("input[name='rid'][value=1]").attr("checked",true); 
		
	});
	$("#save").click(function(){ 
		
		verify();

		var is_cat =  $("#catnameNull").is(":hidden");

		var catname = $("#catname").val();

		var url = $("#url").val();
		
		if (is_cat) {
			
			ajax(catname,url,catparent);

		}else{
			return false;
		}
	}); 
	 

});

function verify(){
	var catname = $("#catname").val();
		
	if (!catname){
		
		$("#catnameNull").show().html("分类名称不能为空");
		return false;
	}else{

		$("#catnameNull").hide();
	}
}


function ajax(catname,url,catparent){
	
    var sUrl = $("#sUrl").val();

    var show = $("input[name='show']:checked").val();

    var catype = $("#catype").val();

    var sortorder = $("#sortorder").val(); 

    var catid = $("#catid").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"catname":catname,"catype":catype,"sUrl":sUrl,"catid":catid,"show":show,"sortorder":sortorder},
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
