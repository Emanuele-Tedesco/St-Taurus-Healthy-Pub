$(function() {
	//carico i contenuti del menu in base alla selezione dell'utente
	$(".link").click(function() {
		var index = $(this).attr("class");
		type = index.substr(0,index.indexOf("-"));
		subtype = index.substr(index.indexOf("-")+1);
		subtype = subtype.substr(0,subtype.indexOf(" "));
		var link = "/contents/menu_picker.php?type="+type+"&subtype="+subtype;
		$("#picker-receiver").load(link);
	});
	//gestisco l'apertura dei popover
	$('[data-toggle="popover"]').popover();
});