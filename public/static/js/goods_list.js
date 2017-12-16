$(function() {

    $(".item").click(function() {
        var item = $(this).attr("itemId");
        openUrl(item);
    });
    
    $(".item").find("a").click( function() {
    	var item = $(this).attr("itemId");
        openUrl(item);
    	return false;
    });
    
    function openUrl(itemId){
    	var url = "/goods/getItemUrl/" + itemId;
        $.get(url,function(data) {
            var obj = eval('(' + data + ')');
            var isOpen = window.open(obj.url);
            if (isOpen == null) {
                window.location.href = obj.url; // 在同当前窗口中打开窗口
            }
        });
    }
});


