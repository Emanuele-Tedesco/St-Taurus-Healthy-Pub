// JavaScript Document
$(function() {
	$("#mod-user-btn").click(function() {
		$(this).fadeToggle(325, function() {
			$("#save-mod-user-btn").fadeToggle(325);
			$("#user_detail_form").removeAttr("novalidate");
			$('[name="tel"], [name="addr"]').removeAttr("disabled").attr("required", "");
			$(".cb").prop("disabled", false);
		});
	});
});

function dismissAlert() {
	setTimeout(function(){
		$('[class="alert alert-info alert-dismissible fade in"]').fadeOut();
	},4 * 1000);
}