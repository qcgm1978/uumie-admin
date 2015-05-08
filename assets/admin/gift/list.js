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
	var giftname = $("#giftname").val();
	var catpye = $("#catpye").val();
	var giftype = $("#giftype").val();

	var url = $("#listUrl").val();

	$.ajax({
	type:"POST",
	dataType:"json",
	data:{"giftype":giftype,"page":page,"giftname":giftname,"catpye":catpye},
	url:url,
	success:function(result) {
		
		$("#content").html('');	
		$.each(result,function(i,item){
			if (item.page && item.pageCount) {
				pagination(item.page,item.pageCount,url);
			}else{

				if (item.pageCount==0) {
					$("#content").append('<tr><td colspan="13">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{
					if (item.gift_type ==1) {

						var conStr = '<tr style="color:#FF0000" id="'+item.gift_id+'"><td class="gname" style="cursor:pointer;color:#0088cd">'+item.gift_name+'</td><td>'+item.gift_cat+'</td><td>逐行刷屏</td><td class="gprice" style="cursor:pointer;color:#0088cd">'+item.gift_price+'</td><td class="gunit" style="cursor:pointer;color:#0088cd">'+item.gift_unit+'</td><td>'+item.is_hidden+'</td><td class="gorder" style="cursor:pointer;color:#0088cd">'+item.sort_order+'</td><td>'+item.operate+'</td></tr>';

					}else{

						var conStr = '<tr id="'+item.gift_id+'"><td class="gname" style="cursor:pointer;color:#0088cd">'+item.gift_name+'</td><td>'+item.gift_cat+'</td><td>全部显示</td><td class="gprice" style="cursor:pointer;color:#0088cd">'+item.gift_price+'</td><td class="gunit" style="cursor:pointer;color:#0088cd">'+item.gift_unit+'</td><td>'+item.is_hidden+'</td><td class="gorder" style="cursor:pointer;color:#0088cd">'+item.sort_order+'</td><td>'+item.operate+'</td></tr>';
					}	
					$("#content").append(conStr);
				}
				
			}
		});
		$(".gname").click(function(){
    	
	        var td = $(this); 
	        var txt = $.trim(td.text()); 
	        var input = $("<input type='text'value='" + txt + "'/>"); 
	        td.html(input);
	        input.click(function () { return false; });
	 
	        input.trigger("focus");
	        var id = $(this).closest('tr').attr("id");
	       
	        input.blur(function () {
            var newtxt = $(this).val(); 
            if (!newtxt) {
            	bootbox.alert("礼物名称不能为空！");
            	return false;
            }
            if (newtxt != txt) {
                td.html(newtxt);
                if (modifyinfo(id,1,newtxt)) {
                	td.html(newtxt); 
                }

            }else{
            	td.html(txt); 
            } 
            
        }); 

    });	
    $(".gprice").click(function(){
    	
	        var td = $(this); 
	        var txt = $.trim(td.text()); 
	        var input = $("<input type='text'value='" + txt + "'/>"); 
	        td.html(input);
	        input.click(function () { return false; });
	 
	        input.trigger("focus");
			var id = $(this).closest('tr').attr("id");
	        input.blur(function () {
            var newtxt = $(this).val();
            if (isNaN(newtxt)) {
            	bootbox.alert("价格的值必须为数字");
            	return false
            } 
            if (newtxt != txt) {
                td.html(newtxt);
                if (modifyinfo(id,2,newtxt)) {
                	td.html(newtxt); 
                }

            }else{
            	td.html(txt); 
            } 
        }); 

    });	
    $(".gunit").click(function(){
    	
	        var td = $(this); 
	        var txt = $.trim(td.text()); 
	        var input = $("<input type='text'value='" + txt + "'/>"); 
	        td.html(input);
	        input.click(function () { return false; });
	 
	        input.trigger("focus");
	        var id = $(this).closest('tr').attr("id");
	       
	        input.blur(function () {
            var newtxt = $(this).val(); 
            if (!newtxt) {
            	bootbox.alert("单位名称不能为空！");
            	return false;
            }
            if (newtxt != txt) {
                td.html(newtxt);
                if (modifyinfo(id,3,newtxt)) {
                	td.html(newtxt); 
                }

            }else{
            	td.html(txt); 
            } 
            
        }); 

    });	
    $(".gorder").click(function(){
    	
	        var td = $(this); 
	        var txt = $.trim(td.text()); 
	        var input = $("<input type='text'value='" + txt + "'/>"); 
	        td.html(input);
	        input.click(function () { return false; });
	 
	        input.trigger("focus");
			var id = $(this).closest('tr').attr("id");
	        input.blur(function () {
            var newtxt = $(this).val(); 
            if (isNaN(newtxt) || newtxt > 50) {
            	bootbox.alert("排序值必须为数字且不能大于50");
            	return false
            }
            if (newtxt != txt) {
                td.html(newtxt);
                if (modifyinfo(id,4,newtxt)) {
                	td.html(newtxt); 
                }

            }else{
            	td.html(txt); 
            } 
        }); 

    });
	}
	});
}

function roominfo(roomid,status,type){
	
	roomid = roomid.substr(0,roomid.length-1);

    recommed(roomid,status,type);

}
function recommed(giftid,status,type){

	var url = $("#updateinfo").val();

	
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"giftid":giftid,"status":status,"type":type},
		url:url,
		success:function(result) {
			
			if (result==1) {

				ajax();
			}else{

				bootbox.alert("系统故障");
			}				
		}
	});
	
}
function del(giftid,status,type){

	var url = $("#updateinfo").val();

	bootbox.confirm("您确定删除该礼物吗？", function(result) {
		if (result) {
			$.ajax({
				type:"POST",
				dataType:"json",
				data:{"giftid":giftid,"status":status,"type":type},
				url:url,
				success:function(result) {
					
					if ( result==2){

						bootbox.alert("恭喜您删除礼物成功！");
						ajax();
					}else{

						bootbox.alert("系统故障");
					}				
				}
			});
		}
	});
}

function modifyinfo(giftid,type,result){

	var url = $("#updateinfo").val();
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"giftid":giftid,"status":result,"type":type},
		url:url,
		success:function(result) {
			if (result==1) {
				return 1;
			}else{
				return 0;
			}				
		}
	});
		
}
