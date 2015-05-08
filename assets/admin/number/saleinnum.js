$(function(){

	$("#all").click(function () {
    	
    	$('#btn').removeAttr("disabled");

        var checked_status = this.checked;

        $("input[name=demo]").each(function () {

            this.checked = checked_status;

        });

    });
    $("#sales").click(function () {
    	var str = '';
        var arrChk = $("input[name=demo]:checked");
        
        $(arrChk).each(function () {

            str +="'"+ this.value+"',";

            

        });
        
        str = str.substr(0,str.length-1);
        
        shelves(str);

    });

	$("#submit").click(function(){
		
		var mingid = $("#mingid").val();
		var maxgid = $("#maxgid").val();
		
		if (mingid &&  maxgid && mingid > maxgid) {

			bootbox.alert("号码段不符合要求");
			
			return false;
		}
		ajax();

	})
	ajax();
});
function ajax(page){
	var url = window.location.href;
	params = url.split("&");
	page = params[1] ? params[1].split("=")[1] : '' ;
	var goodnum = $("#goodnum").val();
	var saleway = $("#saleway").val();
	var gid = $("#gid").val();
	var url = $("#url").val();
	console.log(url);
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"goodnum":goodnum,"page":page,"gid":gid,"saleway":saleway},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="7">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{

					var conStr = '<tr><td>'+item.operat+'</td><td>'+item.gid+'</td><td>'+item.gid_length+'</td><td>'+item.sale_type+'</td><td>'+item.sale_point+'</td><td>'+item.gid_desc+'</td><td>'+item.answer+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}
function shelves(gid){
	bootbox.confirm("您确定要下架吗？", function(result) {
	   if (result) {
	    	var url = $("#shelves").val();
			$.ajax({
				type:"POST",
				dataType:"json",
				data:{"gid":gid},
				url:url,
				success:function(result) {
					if (result==1) {
						bootbox.alert("下架成功");
						ajax();
					
					}else{
						bootbox.alert("系统故障");
					}				
				}
			});
	   }else{
	 	  	// window.history.go(0);
	   }
	});
	
}
