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

            str += this.value+',';

            

        });
        
        str = str.substr(0,str.length-1);
        
        var url = $("#salenumber").val();

        location.href = url+'&gid='+str;

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
	var mingid = $("#mingid").val();
	var maxgid = $("#maxgid").val();
	var gid = $("#gid").val();
	var url = $("#url").val();
	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"goodnum":goodnum,"page":page,"gid":gid,"mingid":mingid,"maxgid":maxgid},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="3">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{

					var conStr = '<tr><td>'+item.operat+'</td><td>'+item.gid+'</td><td>'+item.is_used+'</td><td>'+item.answer+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
	}
	});
}

