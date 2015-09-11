

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
			responsiveWidth: 900
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

	// Navbar Buttons
    // var pagenum = 
 //    var url = window.location.href;
	// var hash = url.substring(url.indexOf("#")+1);
	// if(hash){
	// 	$('.btn-hideshow-signup').hide();
	// } else {
	// 	$('.btn-hideshow-signup').show();
	// }

})(jQuery, this, this.document);


      