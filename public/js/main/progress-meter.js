function setMeterColour() {
    var progressbar = $('.progress');
    var progressmeter = $('.meter');
    var meterpercent = $('.meter-percentage');

    var meterstyle = progressmeter.attr('style');
    var metertext = meterpercent.text();

    // progressmeter.each(function(i){
    // 	if(this.style.width === '1%' || this.style.width === '2%' || this.style.width === '3%' || this.style.width === '4%' || this.style.width === '5%' || this.style.width === '6%' || this.style.width === '7%' || this.style.width === '8%' || this.style.width === '9%' || this.style.width === '10%' || this.style.width === '11%' || this.style.width === '12%' || this.style.width === '13%' || this.style.width === '14%' || this.style.width === '15%' || this.style.width === '16%' || this.style.width === '17%' || this.style.width === '18%' || this.style.width === '19%' || this.style.width === '20%'){
    // 		progressmeter.addClass('meter-20');
    // 	} else if(this.style.width === '21%' || this.style.width === '22%' || this.style.width === '23%' || this.style.width === '24%' || this.style.width === '25%' || this.style.width === '26%' || this.style.width === '27%' || this.style.width === '28%' || this.style.width === '29%' || this.style.width === '30%' || this.style.width === '31%' || this.style.width === '32%' || this.style.width === '33%' || this.style.width === '34%' || this.style.width === '35%' || this.style.width === '36%' || this.style.width === '37%' || this.style.width === '38%' || this.style.width === '39%' || this.style.width === '40%'){
    // 		progressmeter.addClass('meter-40');
    // 	} else if(this.style.width === '41%' || this.style.width === '42%' || this.style.width === '34%' || this.style.width === '44%' || this.style.width === '45%' || this.style.width === '46%' || this.style.width === '47%' || this.style.width === '48%' || this.style.width === '49%' || this.style.width === '50%' || this.style.width === '51%' || this.style.width === '52%' || this.style.width === '53%' || this.style.width === '54%' || this.style.width === '55%' || this.style.width === '56%' || this.style.width === '57%' || this.style.width === '58%' || this.style.width === '59%' || this.style.width === '60%'){
    // 		progressmeter.addClass('meter-60');
    // 	} else if(this.style.width === '61%' || this.style.width === '62%' || this.style.width === '64%' || this.style.width === '64%' || this.style.width === '65%' || this.style.width === '66%' || this.style.width === '67%' || this.style.width === '68%' || this.style.width === '69%' || this.style.width === '70%' || this.style.width === '71%' || this.style.width === '72%' || this.style.width === '73%' || this.style.width === '74%' || this.style.width === '75%' || this.style.width === '76%' || this.style.width === '77%' || this.style.width === '78%' || this.style.width === '79%' || this.style.width === '80%'){
    // 		progressmeter.addClass('meter-80');
    // 	} else if(this.style.width === '81%' || this.style.width === '82%' || this.style.width === '84%' || this.style.width === '84%' || this.style.width === '85%' || this.style.width === '86%' || this.style.width === '87%' || this.style.width === '88%' || this.style.width === '89%' || this.style.width === '90%' || this.style.width === '91%' || this.style.width === '92%' || this.style.width === '93%' || this.style.width === '94%' || this.style.width === '95%' || this.style.width === '96%' || this.style.width === '97%' || this.style.width === '98%' || this.style.width === '99%' || this.style.width === '100%'){
    // 		progressmeter.addClass('meter-100');
    // 	}
    // });

}
;

(function ($, window, document, undefined) {
    setMeterColour();
})(jQuery, this, this.document);