// Results Indicator Highlight
function indicatorHighlight(){
	var indicator = $('#indicator-list > li');
	var indicatorsystem = $('#result-indicator-system');
	var indicatorplanet = $('#result-indicator-planet');
	var indicatorquestion = $('#result-indicator-question');

	var rsystem   = $('#result-system');
	var rplanet   = $('#result-planet');
	var rplay     = $('#result-play');
	var rquestion = $('#result-question');

	if(rsystem.not('.hide')){
		indicatorsystem.addClass('active');
		console.log('active system');
	} else {
		indicatorsystem.removeClass('active');
		console.log('inactive planet');
	}
};

(function($, window, document, undefined){
	indicatorHighlight();
})(jQuery, this, this.document);