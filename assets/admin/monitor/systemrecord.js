$(function(){


	$("#sumit").click(function(){ 
		
		var url = $("#url").val();
		var uid = $("#uid").val();
		if (uid) {
			url = url+'&uid='+uid;
		}
		location = url;
		
	}); 
	$("#search").click(function(){ 
		
		var url = $("#url").val();
		var pag = $("#pag").val();
		if (pag) {
			url = url+'&page='+pag;
		}
		location = url;
		
	});

	 

});
