$(document).ready(function(){
	// new Share(".share-button");
	SocialShareKit.init();

	var sskfb = $('#ssk-facebook');
	var ssktw = $('#ssk-twitter');
	var sskgp = $('#ssk-google-plus');
	var sskpi = $('#ssk-pinterest');
	var sskem = $('#ssk-email');

	width = window.innerWidth;

	// Click Event for FB Share
	sskfb.click(function(){
		if(width <= 768) {
			ga('send', 'event', 'Share', 'Mobile', 'Facebook');
		} else {
			ga('send', 'event', 'Share', 'Desktop', 'Facebook');
		}
	});

	// Click Event for Twitter Share
	ssktw.click(function(){
		if(width <= 768) {
			ga('send', 'event', 'Share', 'Mobile', 'Twitter');
		} else {
			ga('send', 'event', 'Share', 'Desktop', 'Twitter');
		}
	});

	// Click Event for G+ Share
	sskgp.click(function(){
		if(width <= 768) {
			ga('send', 'event', 'Share', 'Mobile', 'Google+');
		} else {
			ga('send', 'event', 'Share', 'Desktop', 'Google+');
		}
	});

	// Click Event for Pinterest Share
	sskpi.click(function(){
		if(width <= 768) {
			ga('send', 'event', 'Share', 'Mobile', 'Pinterest');
		} else {
			ga('send', 'event', 'Share', 'Desktop', 'Pinterest');
		}
	});

	// Click Event for Email Share
	sskem.click(function(){
		if(width <= 768) {
			ga('send', 'event', 'Share', 'Mobile', 'Email');
		} else {
			ga('send', 'event', 'Share', 'Desktop', 'Email');
		}
	});

});