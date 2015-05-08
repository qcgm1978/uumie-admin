function pagination(currentPage,pageCount,url){
	var listUrl = $("#listUrl").val();
	var i = 1;
	var str='';
	var firstPage = '<li class="hidden-xs"><a href="'+listUrl+'&page=1">'+1+'</a></li>';
	var lastPage = '<li><a href="">共'+pageCount+'页</a></li>';
	var prevPage = --currentPage;
	    prevPage = '<li><a href="'+listUrl+'&page='+prevPage+'">上一页</a></li>';
	var nextPage = ++currentPage;
		nextPage++;
	    nextPage = '<li><a href="'+listUrl+'&page='+nextPage+'">下一页</a></li>';
	var morePage = '<li class="disabled hidden-xs"><span>...</span></li>';
	if (currentPage>1) str += prevPage;
	if (currentPage>3) str += firstPage+morePage;
	var start = currentPage-2;
	var end = currentPage+2;
	for (var i = start; i <= end; i++) {
		var liStr = '<li class="hidden-xs"><a href="'+listUrl+'&page='+i+'">'+i+'</a></li>';
		if (currentPage==i){
			liStr = '<li class="active"><a href="'+listUrl+'&page='+i+'">'+i+'</a></li>';
		} 
		if (i<1 || i> pageCount) { var liStr ='';}
		str += liStr;
	}
	if (currentPage<pageCount-2) str += morePage;
	if (currentPage<pageCount) str += nextPage;
	if (pageCount) str += lastPage;
	
	$("#pagination").html("").html(str);
}
