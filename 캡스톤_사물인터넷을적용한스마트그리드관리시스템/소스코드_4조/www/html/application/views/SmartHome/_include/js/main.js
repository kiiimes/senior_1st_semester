jQuery(function($){

var BRUSHED = window.BRUSHED || {};

/* ==================================================
   Mobile Navigation
================================================== */
var mobileMenuClone = $('#menu').clone().attr('id', 'navigation-mobile');

BRUSHED.mobileNav = function(){
	var windowWidth = $(window).width();

	if( windowWidth <= 1000 ) {
		if( $('#mobile-nav').length > 0 ) {
			mobileMenuClone.insertAfter('#menu');
			$('#navigation-mobile #menu-nav').attr('id', 'menu-nav-mobile');
		}
	} else {
		$('#navigation-mobile').css('display', 'none');
		if ($('#mobile-nav').hasClass('open')) {
			$('#mobile-nav').removeClass('open');
		}
	}
}

BRUSHED.listenerMenu = function(){
	$('#mobile-nav').on('click', function(e){
		$(this).toggleClass('open');

		if ($('#mobile-nav').hasClass('open')) {
			$('#navigation-mobile').slideDown(500, 'easeOutExpo');
		} else {	
			$('#navigation-mobile').slideUp(500, 'easeOutExpo');
		}
		e.preventDefault();
	});

	$('#menu-nav-mobile a').on('click', function(){		
		var locati = $(this).attr("class");
		if(locati == "externalMain"){
			location.href="main.html";
		}
		else if(locati == "externalCharges"){
			location.href="charges.html";
		}
		else if(locati == "externalSwitch"){
			location.href="smarthome.html"
		}
		$('#mobile-nav').removeClass('open');
		$('#navigation-mobile').slideUp(500, 'easeOutExpo');


	});
}

/* ==================================================
   Toggle
================================================== */

BRUSHED.toggle = function(){
	var accordion_trigger_toggle = $('.accordion-heading.togglize');

	accordion_trigger_toggle.delegate('.accordion-toggle','click', function(event){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		   	$(this).addClass('inactive');
		}
		else{
		  	$(this).removeClass('inactive');
		  	$(this).addClass('active');
	 	}
		event.preventDefault();
	});
}


/* ==================================================
	Init
================================================== */

$(document).ready(function(){
	
	BRUSHED.mobileNav();
	BRUSHED.listenerMenu();
	BRUSHED.toggle();
});

$(window).resize(function(){
	BRUSHED.mobileNav();
});

});
