function initHeader() {
    width = window.innerWidth;
    height = window.innerHeight;
    target = {x: width/2, y: height/2};

    largeHeader = document.getElementById('main-banner');
    largeHeader.style.height = height+'px';
    //largeHeader.style.maxHeight = 743+'px';
    
    //When Width > Height
	if(height < 320){
		largeHeader.style.height = 480+'px';
	} else if(width < 350){
		largeHeader.style.height = 500+'px';
	} else if(height < 670){
		largeHeader.style.height = 700+'px';
	} else if(height > 743){
		largeHeader.style.height = 743+'px';
	}
};
initHeader();

//Egg
function egg(){
	var kkeys = [];
	var konami = "38,38,40,40,37,39,37,39,66,65";

	$(window).keydown(function(e) {
	  kkeys.push( e.keyCode );

	  if ( kkeys.toString().indexOf( konami ) >= 0 ) {
	    $(window).unbind('keydown',arguments.callee);
	    //Hilary Duff fans will know!
	    var answer = prompt("Please Complete: If the light is off, than it isn't __");
	    
	    if (answer == "on"){
	    	eggyolk();
	    }
	  }

	});
};

function eggyolk(){
	var light = "<div id='light' class='light'></div>";
	var snoop = "<div id='snoop' class='snoop'></div>";
	$("#main-banner").append(light);

	$('#light').on('click', function(){
		$("#main-banner").append(snoop);
	});
};

var ufo = document.getElementById('spacecraft');
TweenLite.set(ufo, {x:-30, y:300});
var ufoFlight = TweenMax.to(ufo, 4, { bezier:{
			values: [{x:300, y:250}, {x:600, y:80}, {x:2000, y:550}],
			autoRotate: true },
			delay: 2,
			scale: 0.5,
			zIndex: 1,
			repeat: 10,
			repeatDelay: 6,
			ease: Power1.easeOut, y: 0 });



//WOW
function wowInitialize(){
	if(width>=570) {
		wow = new WOW(
		  {
		    animateClass: 'animated',
		    offset:       100
		  }
		);
		wow.init();
	}
};
wowInitialize();

function blink(alienColor){
	var alien = $('#alien-' + alienColor);
	var duration = (Math.floor(Math.random() * (8)) + 1) * 1000;
	setTimeout(function() {
	    alien.addClass('blink-' + alienColor);
	    setTimeout(function() {
	        alien.removeClass('blink-' + alienColor);
	        blink(alienColor, duration);
	    }, 1000);
	}, duration);
};

function signup(){
	var emailsubmit = $('#email-address-submit');
	var formemail = $('#signup-form-email');
	var signupform = $('#signup-form');
	var signupbtn = $('#btn-signup');
	var signupbtnholder = $('#signup-btn-holder');
	var signupinstruct = $('#signup-instruct');
	var signupsuccess = $('#signup-success');

	signupform.submit(function(){
		var email = {
			email: formemail.val()
		}

		$.ajax({
			type : 'POST',
			url  : 'http://www.zapzapmath.com/api/pre-launch/subscribe',
			data : email,
			
			success : function(){
				responseMsg();
			}
		});

		return false;
	});

	function responseMsg(){
        
		formemail.fadeOut('fast');
		signupbtn.fadeOut('fast');
		signupform.fadeOut('fast');
		signupinstruct.fadeOut('fast');

		signupbtnholder.append("<div id='signup-success' class='signup-success'><h2>Hooray!</h2><p class='hooray-desc'>Thank you for signing up!<br />We will contact you if you've been chosen.</p><button id='btn-success-ok' class='btn btn--green'>OK</button></div>");
	    
        // Manually force the banner to grow longer because of long copy
        $('#main-banner').css("height","900px");
        console.log($('#main-banner').height());
    };

	function successOK(){
		signupbtnholder.on('click', '#btn-success-ok', function(event){
			// signupbtnholder.children('div').remove();
			// formemail.val('');
			// formemail.fadeIn('slow');
			// signupbtn.fadeIn('slow');
			// signupinstruct.fadeIn('slow');
			// signup();
			location.reload();
			return false;
		});
	};
	successOK();


};

function signup2(){
    ga('send', 'event', { eventCategory: 'Sign Up', eventAction: 'Email Sign Up', eventLabel: 'Sign Up Form'});
    
	var emailsubmit = $('#email-address-submit2');
	var formemail = $('#signup-form-email2');
	var signupform = $('#signup-form2');
	var signupbtnholder = $('#signup-btn-holder');
	var signupinstruct = $('#signup-instruct');
	var signupsuccess = $('#signup-success');

	signupform.submit(function(){
		var email = {
			email: formemail.val()
		}

		$.ajax({
			type : 'POST',
			url  : 'http://www.zapzapmath.com/api/pre-launch/subscribe',
			data : email,
			
			success : function(){
				responseMsg();
			}
		});

		return false;
	});

	function responseMsg(){
        
		formemail.fadeOut('fast');
        // signupbtn.fadeOut('fast');
		signupform.fadeOut('fast');
		signupinstruct.fadeOut('fast');

		signupbtnholder.append("<div id='signup-success' class='signup-success'><h2>Hooray!</h2><p class='hooray-desc'>Thank you for signing up!<br />We will contact you if you've been chosen.</p><button id='btn-success-ok' class='btn btn--green'>OK</button></div>");
	    
        // Manually force the banner to grow longer because of long copy
        $('#main-banner').css("height","900px");
        console.log($('#main-banner').height());
    };

	function successOK(){
		signupbtnholder.on('click', '#btn-success-ok', function(event){
			// signupbtnholder.children('div').remove();
			// formemail.val('');
			// formemail.fadeIn('slow');
			// signupbtn.fadeIn('slow');
			// signupinstruct.fadeIn('slow');
			// signup();
			location.reload();
			return false;
		});
	};
	successOK();


};


function sendmsg(){
	var useremail = $('#email-form-email');
	var usermessage = $('#affiliate-msg');
	var msgsubmit = $('#sendmsgbtn');
	var msgform = $('#emailform');
	var msgsuccess = $('#msg-sent-success');
	var btnmsgok = $('#btn-msg-ok');

	msgform.submit(function(){
		var msg = {
			email	: useremail.val(),
			message : usermessage.val()
		}

		$.ajax({
			type : 'POST',
			url  : 'http://www.zapzapmath.com/api/pre-launch/contact-us',
			data : msg,

			success : function(msg){
				responseMsg();
			}
		});

		function responseMsg(){
			msgsuccess.fadeIn('fast');
			msgsuccess.addClass('bounceIn animated');
			$('#affiliate-outer-wrapper').fadeOut('fast');
		};

		function msgsentOK(){
			var emailform = $('#email-form');
			var overlayinnercontent = $('#affiliate-overlay-inner');

			btnmsgok.click(function(){
				$('body').removeClass('noscroll');
				msgsuccess.addClass('bounceOut animated');
				msgsuccess.fadeOut('fast');
				$('#overlay').fadeOut('fast');
				useremail.val('');
				usermessage.val('');
				location.reload(true);
			});
		};
		msgsentOK();

		return false;
	});
};

ouibounce(document.getElementById('ouibounce-modal'));

$(document).ready(function(){

    // Manually force the banner to grow longer because of long copy
    $('#main-banner').css("height","900px");
    
	//OuiBounce Modal
	$('body').on('click', function() {
		$('#ouibounce-modal').hide();
	});

	$('#ouibounce-modal .modal-footer').on('click', function() {
		$('#ouibounce-modal').hide();
	});

	$('#ouibounce-modal .modal').on('click', function(e) {
		e.stopPropagation();
	});

	//Egg
	egg();

	//Form Validation
	var formEmail = $('#emailform');
	var formSignup = $('#signupform');

	formEmail.validate();
	formSignup.validate();

	//Posting Email Addresses to backend
	signup();
	sendmsg();

	//Function Calls for random blinking
	blink('green');
	blink('orange');

	//Form Show
	var btnshowform 	= $('#btn-signup');
	var signupform 		= $('#signup-form');
	var btnrepeatcta	= $('#btn-repeat-cta');

	function formShow() {
		btnshowform.click(function(){
			formSlideToggle();
		});
	};
	formShow();

	function formSlideToggle() {
		signupform.slideToggle('fast');
	};

	function formSlideDown(){
		signupform.slideDown('fast');
	};

	function scrollToTop() {
		$('html, body').animate({
			scrollTop : 0
		},500);
		return false;
	};

	function repeatCTA() {
		btnrepeatcta.click(function(){
			scrollToTop();
			formSlideDown();
		});
		
	};
	repeatCTA();
	
	//Dynamic Copyright Date
	function dynamicYear() {
		var year = $('#year');
		year.html(new Date().getFullYear());
	};
	dynamicYear();


	//Trigger Overlay
	var overlaytrigger = $('#trigger-overlay');

	function triggerOverlay(){
		overlay.fadeIn('fast');
		overlaycontent.fadeIn('fast');
	};

	function btnTriggerOverlay() {
		overlaytrigger.click(function(){
			$('body').addClass('noscroll');
			triggerOverlay();
		});
	};
	btnTriggerOverlay();

	//Show Email Form in Overlay
	var btnopenemailform = $('#btn-open-email-form');
	var emailform = $('#email-form');
	var overlayinnercontent = $('#affiliate-overlay-inner');

	btnopenemailform.click(function(){
		emailform.slideToggle('fast');
		overlayinnercontent.toggleClass('pushaliens');
	});

	//Overlay Styles
	var closebtn = $('#btn-close-overlay');
	var overlay = $('#overlay');
	var overlaycontent = $('#affiliate-outer-wrapper');

	function closeOverlay() {
		overlay.fadeOut('fast');
		overlaycontent.fadeOut('fast');
	};

	function btncloseoverlay() {
		closebtn.click(function(){
			closeOverlay();
			$('body').removeClass('noscroll');
		});
	};
	btncloseoverlay();

	//Menu Button
	var menubtn = $('#menu-btn');
	var menu = $('#menu-list');
	var menuitem = $('#menu-list li a');

	function toggleMenu() {
		menu.slideToggle('fast');
	};

	menubtn.click(function(){
		toggleMenu();
		closeMenu();
	});

	function closeMenu(){
		if(width < 569) {
			menuitem.click(function(){
				// menu.hide('fast');
				menu.slideUp('fast');
			});
		}
	};

	//Scroll to Anchor
	$(function(){
        $('a[href*=#]:not([href=#])').click(function(){
            if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname){

                var target = $(this.hash);
                target = target.length ? target : $('[name='+this.hash.slice(1)+']');

                // menu.slideUp('slow');

                if(target.length){
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    

                    return false;
                }
            }
        });
    });
    
    //Back to top button
    var topbtn = $('#btn-to-top');
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            topbtn.fadeIn();
        } else {
            topbtn.fadeOut();
        }
    });
    
    //Click event to scroll to top
    topbtn.click(function(){
        scrollToTop();
    });



});