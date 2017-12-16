$(function(){
    var url = "/buyinventory/videoHtml_" + buyinventoryId+".html";
    $.get(url,function(data) {
		$(".video").html(data)
    });
})