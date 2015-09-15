

(function($, window, document, undefined){
	$(document).foundation();

	var vpw = window.innerWidth;

	if(vpw < 641) {
		console.log('small down');
	} else {
		$('#fullpage').fullpage({
			anchors: ['1stPage', '2ndPage', '3rdPage', '4thPage', '5thPage', '6thPage'],
			sectionsColor: ['#C63D0F', '#f0f0f0', '#7E8F7C'],
			navigation: true,
			navigationPosition: 'right',
			navigationTooltips: ['Zap Zap Math', 'As Seen On', 'Worlds of Content', 'Detailed Reports', 'Play & Learn', 'Newsletter Signup'],
			responsiveWidth: 900,
			scrollBar: true
		});

		console.log('medium up');
	}

	console.log(vpw);

	var hamburger = $('.small-menu-icon');
	var menuitems = $('.menu-items-list');

	hamburger.click(function(){
		menuitems.stop().slideToggle();
		menuitems.parent().toggleClass('menu-opened');
	});

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

	// TweenMax
	// var ufo = document.getElementById('spacecraft');
	// TweenLite.set(ufo, {x:-30, y:300});
	// var ufoFlight = TweenMax.to(ufo, 4, { bezier:{
	// 			values: [{x:300, y:250}, {x:600, y:80}, {x:3000, y:550}],
	// 			autoRotate: true },
	// 			delay: 2,
	// 			scale: 0.5,
	// 			zIndex: 1,
	// 			repeat: 10,
	// 			repeatDelay: 6,
	// 			ease: Power1.easeOut, y: 0 });
	//var tlcomet = new TimelineLite({paused:false});
	// tlcomet.to("#comet1", 1, {x:750})
	// 		.to("#comet2", 1, {x:750})
	// 		.to("#comet3", 1, {x:750})
	// TweenMax.staggerTo(".comet", 1, {rotation:360, y:100}, 0.5);

	// TweenLite.fromTo(photo, 1.5, {width:0, height:0}, {width:100, height:200});

	var comet1 = document.getElementById('comet1');
	var comet2 = document.getElementById('comet2');
	var comet3 = document.getElementById('comet3');
	var tlcomet1 = TweenMax.to(comet1, 1, {x:-1000, y:1000, delay: 1, repeat: 50, repeatDelay: 10});
	var tlcomet2 = TweenMax.to(comet2, 1, {x:-1000, y:1000, delay: 4, repeat: 50, repeatDelay: 10});
	var tlcomet2 = TweenMax.to(comet3, 1, {x:-1000, y:1000, delay: 6, repeat: 50, repeatDelay: 10});

    // Shooting UFO
    function ufoshoot(){
		var ufo = $('#ufo-shooter');
		var duration = (Math.floor(Math.random() * (8)) + 1) * 1000;
		setTimeout(function() {
		    ufo.addClass('spacecraft-shoot');
		    setTimeout(function() {
		        ufo.removeClass('spacecraft-shoot');
		    }, 1000);
		}, duration);
	};
	ufoshoot();

})(jQuery, this, this.document);


      