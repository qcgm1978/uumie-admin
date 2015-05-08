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

	});

	ajax();
});
function ajax(page){
	var url = window.location.href;
	params = url.split("&");
	page = params[1] ? params[1].split("=")[1] : '' ;
	var goodnum = $("#goodnum").val();
	var saleway = $("#saleway").val();
	var gid = $("#gid").val();
	var url = $("#listUrl").val();

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
					$("#content").append('<tr><td colspan="13">没有查询到任何记录</td></tr>');
					pagination(item.page,item.pageCount,url);
				}else{

					var conStr = '<tr id="'+item.room_id+'"><td id="'+item.room_id+'">'+item.operat+'</td><td>'+item.room_id+'</td><td  class="rname" style="cursor:pointer;color:#0088cd">'+item.room_name+'</td><td>'+item.starttime+'</td><td>'+item.bitrate+'</td><td class="mname" style="cursor:pointer;color:#0088cd">'+item.max_user+'</td><td>'+item.is_recommend+'</td><td>'+item.is_lock+'</td><td>'+item.is_hidden+'</td><td class="sname" style="cursor:pointer;color:#0088cd">'+item.sort_order+'</td><td>'+item.room_server+'</td><td>'+item.room_owner_gid+'</td><td>'+item.answer+'</td></tr>';
					$("#content").append(conStr);
				}
				
			}
		});		
		$(".rname").click(function(){
    	
	        var td = $(this); 
	        var txt = $.trim(td.text()); 
	        var input = $("<input type='text'value='" + txt + "'/>"); 
	        td.html(input);
	        input.click(function () { return false; });
	 
	        input.trigger("focus");
	        var id = $(this).closest('tr').attr("id");
	       
	        input.blur(function () {
            var newtxt = $(this).val(); 
            var len = getByteLen(newtxt);
            if (len<2 || len>16) {
            	bootbox.alert("账号最少2个字符，最多只能是8个汉字或16字母!");
            	return false;
            }
            if (newtxt != txt) {
                td.html(newtxt);
                if (modifyinfo(id,5,newtxt)) {
                	td.html(newtxt); 
                }

            }else{
            	td.html(txt); 
            } 
            
        }); 

    });
	$(".mname").click(function(){
    	
	        var td = $(this); 
	        var txt = $.trim(td.text()); 
	        var input = $("<input type='text'value='" + txt + "'/>"); 
	        td.html(input);
	        input.click(function () { return false; });
	 
	        input.trigger("focus");
			var id = $(this).closest('tr').attr("id");
	        input.blur(function () {
            var newtxt = $(this).val();
            if (isNaN(newtxt) || newtxt > 65535) {
            	bootbox.alert("单个房间最大人数必须为数字且不能超过 65535 人");
            	return false
            } 
            if (newtxt != txt) {
                td.html(newtxt);
                if (modifyinfo(id,6,newtxt)) {
                	td.html(newtxt); 
                }

            }else{
            	td.html(txt); 
            } 
        }); 

    });
    $(".sname").click(function(){
    	
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
                if (modifyinfo(id,7,newtxt)) {
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
function selaction(sel){

	switch(sel){
		case '1':
			var status = 4;
			var type = 4;
			var constr = '您确定要删除选中的全部房间吗？';
		  break;
		case '2':
		  	var status = 1;
		  	var type = 1;
		  break;
		case '3':
		  	var status = 0;
		  	var type = 1;
		  break;
		case '4':
		  	var status = 1;
		  	var type = 2;
		  	var constr = '您确定要锁定选中的全部房间吗？';
		  break;
		case '5':
		  	var status = 0 ;
		  	var type = 2;
		  break;
		case '6':
		  	var status = 1;
		  	var type = 3;
		  	var constr = '您确定要隐藏选中的全部房间吗？';
		  break;
		case '7':
		  	var status = 0;
		  	var type = 3;
		  break;     
	}
	
	var roomid = '';
	var arrChk = $("input[name=demo]:checked");

	$(arrChk).each(function () {

        roomid +="'"+ this.value+"',";
    });
    if (roomid && sel) {

    	if (sel==4 || sel==6 || sel==1) {

    		bootbox.confirm(constr,function(result){

    			if (result) {

    				roominfo(roomid,status,type);
    			}
    		});

    	}else{

    		roominfo(roomid,status,type);
    	 
  	    }
    }

}

function roominfo(roomid,status,type){
	
	roomid = roomid.substr(0,roomid.length-1);

    recommed(roomid,status,type);

}
function recommed(roomid,status,type){

	var url = $("#updateinfo").val();
	
	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"roomid":roomid,"status":status,"type":type},
		url:url,
		success:function(result) {
			
			if (result==1) {

				ajax();
			}else if( result==2){

				bootbox.alert("恭喜您删除房间成功！");
				ajax();
			}else{

				bootbox.alert("系统故障");
			}				
		}
	});
	
}

function modifyinfo(roomid,type,result){

	var url = $("#updateinfo").val();

	$.ajax({
		type:"POST",
		dataType:"json",
		data:{"roomid":roomid,"status":result,"type":type},
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
