
(function($, window, document, undefined){
	$(document).foundation();

	$('#fullpage').fullpage({
		anchors: ['1stPage', '2ndPage', '3rdPage', '4thPage', '5thPage', '6thPage'],
		sectionsColor: ['#C63D0F', '#f0f0f0', '#7E8F7C'],
		navigation: true,
		navigationPosition: 'right',
		navigationTooltips: ['First page', 'Second page', 'Third and last page'],
		responsiveWidth: 900
	});

})(jQuery, this, this.document);


      