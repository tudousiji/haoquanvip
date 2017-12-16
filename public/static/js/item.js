$(function(){
	$(".item").click(function(){
		
		var url = "/goods/getItemUrl/"+item;
		$.get(url,function(data){
			var obj = eval('(' + data + ')');
			var isOpen =window.open(obj.url); 
			if(isOpen==null){
				window.location.href=obj.url;     //在同当前窗口中打开窗口
			}
		})
	})
})