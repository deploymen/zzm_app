

(function($, window, document, undefined){
	$(document).foundation();

	var vpw = window.innerWidth;
	var fullpageEl = $('#fullpage');
	var hamburger = $('.small-menu-icon');
	var menuitems = $('.menu-items-list');
	var topbar = $('.launch-top-bar');

	if(vpw < 1023) {
		console.log('small down');
		fullpageEl.removeClass('full-page')
	} else if (vpw > 1024) {
		$('.full-page').fullpage({
			anchors: ['1stPage', '2ndPage', '3rdPage', '4thPage', '5thPage', '6thPage'],
			sectionsColor: ['#C63D0F', '#f0f0f0', '#7E8F7C'],
			navigation: true,
			navigationPosition: 'right',
			navigationTooltips: ['Zap Zap Math', 'As Seen On', 'Worlds of Content', 'Detailed Reports', 'Play & Learn', 'Newsletter Signup'],
			responsiveWidth: 900,
			scrollBar: true
		});

		console.log('medium up');
	} else if (vpw < 640) {
		hamburger.click(function(event){
			menuitems.stop().slideToggle('fast');
			menuitems.parent().toggleClass('menu-opened');
			topbar.toggleClass('solid');
			// event.stopPropagation();
			console.log('clicked hamburger');
		});

		$(document).click(function(){
			menuitems.slideUp('fast');
			topbar.removeClass('solid');
		});
	}

	

	$('.slide-holder').slick({
		autoplay: true,
  		autoplaySpeed: 2000
	});

	// Navbar Buttons - Little sign up button
    var topOfOthDiv = $("#page1").offset().top;
    var orangesignupbtn = $('#btn-hideshow-signup');
    orangesignupbtn.hide();

    if(vpw < 641) {
    	orangesignupbtn.show();
    } else {
    	$(window).scroll(function (){
	    	if ($(window).scrollTop() > topOfOthDiv ){
	    		orangesignupbtn.show();
	    	} else {
	    		orangesignupbtn.hide();
	    	}
	    });
    }

    //Dynamic Copyright Date
	function dynamicYear() {
		var year = $('#year');
		year.html(new Date().getFullYear());
	};
	dynamicYear();

	// Comet Animation
	var comet1 = document.getElementById('comet1');
	var comet2 = document.getElementById('comet2');
	var comet3 = document.getElementById('comet3');
	// Shooting UFO
    function ufoshoot(){
    	var tlcomet1 = TweenMax.to(comet1, 3, {x:-2000, y:2000, delay: 1, repeat: 50, repeatDelay: 10});
		var tlcomet2 = TweenMax.to(comet2, 2, {x:-2000, y:2000, delay: 4, repeat: 50, repeatDelay: 10});
		var tlcomet2 = TweenMax.to(comet3, 5, {x:-2000, y:2000, delay: 6, repeat: 50, repeatDelay: 10});

		var ufo = $('#ufo-shooter');
		var duration = (Math.floor(Math.random() * (8)) + 1) * 1000;
		setTimeout(function() {
		    ufo.addClass('spacecraft-shoot');
		    setTimeout(function() {
		        ufo.removeClass('spacecraft-shoot');
		        ufoshoot(duration);
		    }, 1000);
		}, duration);
	};
	if(vpw > 641) {
		ufoshoot();
	} else {
		// comet1.style.display = 'none';
		// comet2.style.display = 'none';
		// comet3.style.display = 'none';
	}

	

})(jQuery, this, this.document);


      