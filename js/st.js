/**
 * @author Manu
 */

function open_main_modal() {
	$("#message-modal").modal("show");
}

function load_reg_alert() {
	$("#registration-alert").load("../contents/registration_alert.php").show();
}

function force_open_login_modal(type) {
	$("#login-modal").load("login_modal.php").modal();
	if (type === 1) {
		$(function() {
			$("#registration-form").collapse("show");
		});
	}
}

//previene il submit del form di registrazione tramite tasto enter con password errate
$(window).keydown(function(event){
	if(event.keyCode === 13) {
	  passCheck();
	}
});

//Temporizza la chiusura dei modal di notifica
function close_modal_4() {
	setTimeout(function() {
		$('#message-modal').modal('hide');
	}, 4 * 1000);
}

//lancia il controllo sulla sessione
setInterval(function(){
	$.ajax({ url : '../contents/functions.php?action=check_session'});
	console.log('check');
},60 * 1000);

function clickReload() {
	$("a").click(function(){
		//alert('reload!');
		location.reload("true");
	});
}

$(function(){
	
	//lancia il controllo sulla sessione
	/*$("a").click(function(){
		console.log('session_check');
		$.ajax({ url : '../contents/functions.php?action=check_session'});
	});*/
	
	//toggle per nascondere il menu
	$(".nav-toggle, .navbar-collapse .no-dropdown").click(function() {
		$(".navbar-collapse").slideToggle();
	});
	
	$(".dropdown-toggle").click(function() {
		$(".dropdown-menu .inverted").slideToggle();
	});
	
	
	//slideup della navbar allo scroll della pagina
	$(document).on("scroll", function() {
		$(".navbar-collapse").slideUp();
	});
	
	//affix della navbar
	$(".navbar").affix({offset: {top: $("header").outerHeight(true)}});
	
	//disabilita i link per i link disabilitati
	$(".disabled a").removeAttr("href");
	
	//carico i contenuti del menu
	$("#picker-receiver").load("contents/menu_picker.php");
	
	//gestione delle pagine dei modal
	//carico il modal della login
	$("#login-link").click(function() {
		$("#login-modal").load("login_modal.php").modal();
	});
	
	//carico il modal dei messaggi
	$('#message-modal').load("contents/message_modal.php");
		
	//Angular
	//ngRuote
	var app = angular.module("page-router", ["ngRoute"]);
	app.config(function($routeProvider) {
		$routeProvider
		.when("/filosofia", {templateUrl: "filosofia.php"})
		.when("/contatti", {templateUrl: "contatti.php"})
		.when("/menu_sala", {templateUrl: "menu_sala.php"})
		.when("/menu_asporto", {templateUrl: "not_found.php"})
		.when("/user_details", {templateUrl: "user_details.php"})
		.otherwise({templateUrl : "main.php"});
	});
	
	/*$(".bulb").click(function(){
		//console.log($(this).attr("src"));
	    if($(this).attr("src") === "image/pic_bulboff.gif") {
	    	$(this).attr("src","image/pic_bulbon.gif");
	    }
	    else {
	    	$(this).attr("src","image/pic_bulboff.gif");
	    }
	    //$(".bulb").toggle();
	});
	
	$(".lighton").click(function() {
		if($(".bulb").attr("src") === "image/pic_bulboff.gif") {
			$(".bulb").attr("src","image/pic_bulbon.gif");
		}
		else {
			$(".bulb").attr("src","image/pic_bulboff.gif");
		}
	});*/
	
	//testo circolare
	/*$(function(){
		$(".h1-head").circleType({fitText:true, radius: 825}); 
		$(function() {
			$(".char4").css({"font-family": "lcalling", "top": "5px", "transform": "rotate(-7.1deg)", "transform-origin": "center 25.5em 0px"});
		});
		//$(".span.char4").css( "font-family", "Lucida Calligraphy");
	});*/
	
	//maps
	function myMap() {
	    var mapOptions = {
	        center: new google.maps.LatLng(51.5, -0.12),
	        zoom: 10,
	        mapTypeId: google.maps.MapTypeId.HYBRID
	    }
		var map = new google.maps.Map($(".map"), mapOptions);
	}
});