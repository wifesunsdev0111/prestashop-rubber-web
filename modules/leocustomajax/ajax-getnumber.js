/*
* 20011-2013 leoTheme.Com
*/
//when document is loaded...
$(document).ready(function(){
	//get category id
	var leoCatList = "";
	$("#categories_block_left .leo-qty").each(function(){
	     if (leoCatList) leoCatList += ","+$(this).attr("id");
	     else leoCatList = $(this).attr("id")
	});
	leoCatList = leoCatList.replace(/leo-cat-/g,"");
	
	if (leoCatList!="") {
		$.ajax({
			type: 'POST',
			headers: { "cache-control": "no-cache" },
			url: baseDir + 'modules/leopronumofcat/getnumber-ajax.php' + '?rand=' + new Date().getTime(),
			async: true,
			cache: false,
			dataType : "json",
			data: 'cat_list=' + leoCatList + '&rand=' + new Date().getTime(),
			success: function(jsonData)	{
				for(i=0;i<jsonData.length;i++){
					//$("#leo-cat-"+jsonData[i].id_category).show();
					$("#leo-cat-"+jsonData[i].id_category).html(jsonData[i].total);
					$("#leo-cat-"+jsonData[i].id_category).show();
				}
			},
			error: function() {}
		});
	}
});
