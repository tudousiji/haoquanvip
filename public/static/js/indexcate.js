$(function(){
	var url = "/indexcate/getIndexCateUrl/" + id;
	//alert(url);
	$.get(url,function(data) {
      var obj = eval('(' + data + ')');
      //alert(obj.url);
      if(obj.Code==0){
    	  if(obj.type==0){
    		 var html ='<iframe id="iframepage" scrolling="no" onload="changeFrameHeight()" frameborder="0" src="'+obj.url+'"></iframe>'
    	  //$("#D-main").html(html); 
    	  }else{
    		  var isOpen = window.open(obj.url);
            if (isOpen == null) {
                window.location.href = obj.url; // 在同当前窗口中打开窗口
            }
    	  }
    	  
      }
      
  });
	
	
	
	
});





