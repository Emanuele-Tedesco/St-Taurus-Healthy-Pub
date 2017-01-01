/**
 * @author Manu
 */

function passCheck() {
	var pass = $("#passwrd").val();
	var pass2 = $("#repasswrd").val();
	if (pass != pass2) {
		$("#repasswrd").val("").attr("title", "Le password non corrispondono!").tooltip("show");
	}
}

$(function() {
	
	$("*").hover(function() {
		$("#repasswrd").tooltip("destroy").removeAttr("title");
	});
	
});