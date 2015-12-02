

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
			// anchors: ['1stPage', '2ndPage', '3rdPage', '4thPage', '5thPage', '6thPage'],
			sectionsColor: ['#C63D0F', '#f0f0f0', '#7E8F7C'],
			navigation: true,
			navigationPosition: 'right',
			// navigationTooltips: ['Zap Zap Math', 'As Seen On', 'Worlds of Content', 'Detailed Reports', 'Play & Learn', 'Newsletter Signup'],
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

	// Forms
	var emailnotify = $('#notify-email-field');
	var emailnewsletter = $('#newsletter-email-field');
	var btnnotify = $('#btn-register-interest');
	var btnnewspaper = $('#btn-register-newsletter');
	var formnotify = $('#form-register-interest');
	var formnewsletter = $('#form-register-newsletter');
	var inputnotify = $('.form-get-notified input[type="text"]');
	var inputnewsletter = $('.newsletter-opt-in input[type="text"]');
	var errornotify = $('.opt-notify-feedback');
	var errornewsletter = $('.opt-newsletter-feedback');
	var errormsg;
	var successmsg;

	function optErrorResponse(optInput, optMsg) {
		optInput.addClass('opt-form-error');
		optMsg.html(errormsg);
		errornotify.addClass('error');
	}

	// function optSuccessResponse(optInput, optMsg) {
	// 	optInput.removeClass('opt-form-error');
	// 	optInput.addClass('opt-form-success');
	// 	optMsg.html(successmsg);
	// 	optInput.val('');
	// }

	function optNotify(){
		var data = {
			email: emailnotify.val(),
			launch_notified: 1,
			news_letter: 0
		}

		$.ajax({
			type : 'POST',
			url  : '/api/launch-notification',
			data : data,
			success : function(data){
				var status = data.status;
				var message = data.message;
				// console.log('You  have successfully signed up for iOS Launch Notification');
				
				if (status === 'success') {
					errornotify.removeClass('error');
					errornotify.addClass('success');
					inputnotify.removeClass('opt-form-error');
					inputnotify.addClass('opt-form-success');
					errornotify.html('You have successfully signed up!');
					inputnotify.val('');
				} else if (status === 'fail'){
					console.log(message);
					optErrorResponse(inputnotify, errornotify);
					if(message === 'invalid email format') {
						// inputnotify.addClass('opt-form-error');
						//optErrorResponse(inputnotify, errornotify);
						errormsg = "Invalid Email Format"
					} else if (message === 'missing parameters'){
						//optErrorResponse(inputnotify, errornotify);
						errormsg = "Please input an email";
					}
				}
			}
		});

		return false;
	}

	function optNewsletter() {
		var data = {
			email: emailnewsletter.val(),
			launch_notified: 0,
			news_letter: 1
		}

		$.ajax({
			type : 'POST',
			url  : '/api/launch-notification',
			data : data,
			success : function(data){
				var status = data.status;
				var message = data.message;
				// alert('You have successfully signed up for our Newsletter');

				if (status === 'success') {
					errornewsletter.removeClass('error');
					errornewsletter.addClass('success');
					inputnewsletter.removeClass('opt-form-error');
					inputnewsletter.addClass('opt-form-success');
					errornewsletter.html('You have successfully signed up!');
					inputnewsletter.val('');
				} else if (status === 'fail'){
					console.log(message);
					optErrorResponse(inputnewsletter, errornewsletter);
					if(message === 'invalid email format') {
						//optErrorResponse(inputnewsletter, errornewsletter);
						errormsg = "Blah Email Format"
					} else if (message === 'missing parameters'){
						//optErrorResponse(inputnewsletter, errornewsletter);
						errormsg = "Please input an email";
					}
				}
			}
		});

		return false;
	}

	// btnnotify.click(function(){
	// 	console.log('notify me when ios launches');
	// });
	// btnnewspaper.click(function(){
	// 	console.log('send me a newsletter');
	// });

	formnotify.submit(function() {
		// console.log('notify me when ios launches');
		optNotify();
		return false;
	});
	formnewsletter.submit(function() {
		// console.log('send me a newsletter');
		optNewsletter();
		return false;
	});
	
	

})(jQuery, this, this.document);


      