$(function(){
	var url = $("#url").val();
    var page = $("#page").val();
    var pageCount = $("#pageCount").val();
    var count = $("#count").val();
    pagination(page,pageCount,count,url);
    $("#stime").jcDate({                 
      IcoClass : "jcDateIco",
      Event : "click",
      Speed : 100,
      Left : 0,
      Top : 28,
      format : "-",
      Timeout : 100,
   });
   $("#etime").jcDate({                 
      IcoClass : "jcDateIco",
      Event : "click",
      Speed : 100,
      Left : 0,
      Top : 28,
      format : "-",
      Timeout : 100,
   });
   var tpage = $("#tpage").text();
   var cpage = $("#cpage").text();
      
    if (tpage==1  || parseInt(tpage) ==parseInt(cpage)) {
      
      $("#downpage").hide();
    }
    $("#search").click(function(){

	    var url = $("#url").val();
	    var pag = $("#pag").val();
	    var tpage = $("#tpage").text();
	    if(pag >tpage){

	        alert("您输入的页数不存在,请重新输入");
	        $("#pag").val('');
	        return false;
	    }
	    if (pag) {
	        location = url+'&page='+pag;
	    }
	});
});
function pagination(currentPage,pageCount,count,url){
	// currentPage = 10
	var str = '';
	var prevPage = --currentPage;
	prevPage = prevPage ? prevPage :1;
	var nextPage = ++currentPage;
	nextPage++;
	nextPage = '<a href="'+url+'&page='+nextPage+'"><span id="downpage">下一页</span></a>';
	str += '<p>共 '+count+' 条记录，共 <span id="tpage">'+pageCount+'</span> 页，当前显示第 <span id="cpage">'+currentPage+'</span> 页</p>';
        str +='<p class="jpage"><span id="uppage"><a href="'+url+'&page='+prevPage+'">上一页</a></span>';
        var start = currentPage-2;
		var end = currentPage+2;
		for (var i = start; i <= end; i++) {
			if (i<1 || i> pageCount) {
				str +='';
			}else{
				if (currentPage==i) {
					
					str +='<a>&nbsp;'+i+'&nbsp;</a>'; 
				}else{

					str +='<a href="'+url+'&page='+i+'">&nbsp;'+i+'&nbsp;</a>'; 
				}

			}
		}
        
        str +=nextPage; 
        str +=' <a style="text-decoration:none;cursor:default;">跳转到&nbsp;</a>';  
        str +='<input type="text"  id="pag" /> ';
        str +=' 页 <input name="" id="search" type="button" value="GO" /> </p>';
	
	$(".jump").html("").html(str);
}
